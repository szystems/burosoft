<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Traits\ConsumesExternalServices;
use App\Models\Subscription;

class PayPalService
{
    use ConsumesExternalServices;

    protected $baseUri;

    protected $clientId;

    protected $clientSecret;

    protected $plans;

    public function __construct()
    {
        $this->baseUri = config('services.paypal.base_uri');
        $this->clientId = config('services.paypal.client_id');
        $this->clientSecret = config('services.paypal.client_secret');
        $this->plans = config('services.paypal.plans');
    }

    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    public function decodeResponse($response)
    {
        return json_decode($response);
    }

    public function resolveAccessToken()
    {
        $credentials = base64_encode("{$this->clientId}:{$this->clientSecret}");

        return "Basic {$credentials}";
    }

    public function handlePayment(Request $request)
    {
        $order = $this->createOrder($request->value, $request->currency);

        $orderLinks = collect($order->links);

        $approve = $orderLinks->where('rel', 'approve')->first();

        session()->put('approvalId', $order->id);

        return redirect($approve->href);
    }

    public function handleApproval()
    {
        if (session()->has('approvalId')) {
            $approvalId = session()->get('approvalId');

            $payment = $this->capturePayment($approvalId);

            $name = $payment->payer->name->given_name;
            $payment = $payment->purchase_units[0]->payments->captures[0]->amount;
            $amount = $payment->value;
            $currency = $payment->currency_code;

            return redirect()
                ->route('checkout')
                ->withSuccess(['payment' => "Gracias, {$name}. Hemos recibido tu pago por: {$amount}{$currency}"]);
        }

        return redirect()
            ->route('checkout')
            ->withErrors('No podemos recuperar su plataforma de pago. Por favor inténtalo de nuevo.');
    }

    public function handleSubscription(Request $request)
    {
        $subscription = $this->createSubscription(
            $request->plan,
            $request->user()->name,
            $request->user()->email
        );

        $subscriptionLinks = collect($subscription->links);

        $approve = $subscriptionLinks->where('rel', 'approve')->first();

        session()->put('subscriptionId', $subscription->id);

        return redirect($approve->href);
    }

    public function validateSubscription(Request $request)
    {
        if (session()->has('subscriptionId')) {
            $subscriptionId = session()->get('subscriptionId');

            session()->forget('subscriptionId');

            return $request->subscription_id == $subscriptionId;
        }

        return false;
    }

    public function createOrder($value, $currency)
    {
        return $this->makeRequest(
            'POST',
            '/v2/checkout/orders',
            [],
            [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    0 => [
                        'amount' => [
                            'currency_code' => strtoupper($currency),
                            // 'value' => round($value * $factor = $this->resolveFactor($currency)) / $factor,
                            'value' => $value,
                        ]
                    ]
                ],
                'application_context' => [
                    'brand_name' => config('app.name'),
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                    'return_url' => route('approval'),
                    'cancel_url' => route('cancelled'),
                ]
            ],
            [],
            $isJsonRequest = true,
        );
    }

    public function capturePayment($approvalId)
    {
        return $this->makeRequest(
            'POST',
            "/v2/checkout/orders/{$approvalId}/capture",
            [],
            [],
            [
                'Content-Type' => 'application/json',
            ],
        );
    }

    public function createSubscription($planSlug, $name, $email)
    {
        return $this->makeRequest(
            'POST',
            '/v1/billing/subscriptions',
            [],
            [
                'plan_id' => $this->plans[$planSlug],
                'subscriber' => [
                    'name' => [
                        'given_name' => $name,
                    ],
                    'email_address' => $email,
                ],
                'application_context' => [
                    'brand_name' => config('app.name'),
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'SUBSCRIBE_NOW',
                    'return_url' => route('subscribe.approval', ['plan' => $planSlug]),
                    'cancel_url' => route('subscribe.cancelled'),
                ]
            ],
            [],
            $isJsonRequest = true,
        );
    }

    public function resolveFactor($currency)
    {
        $zeroDecimalCurrencies = ['JPY'];

        if (in_array(strtoupper($currency), $zeroDecimalCurrencies)) {
            return 1;
        }

        return 100;
    }

    public function getNextPayment($subscriptionId)
    {
        $response = $this->getSubscription($subscriptionId);
        $subscriptionInfo = collect($response);
        // dd($response);
        $status = $response->status;
        if($status == 'SUSPENDED')
        {

            $subscription = Subscription::where('subscription_id', $subscriptionId)->first();
            $subscription->status = $status;
            $subscription->update();

        }elseif($status == 'ACTIVE')
        {
            $nextBillingTime = $response->billing_info->next_billing_time;


            $timestamp = strtotime($nextBillingTime);
            $nextBillingTime = date("Y-m-d H:i:s", $timestamp);
            $subscription = Subscription::where('subscription_id', $subscriptionId)->first();
            $subscription->next_billing_time = $nextBillingTime;
            $subscription->active_until = $nextBillingTime;
            $subscription->status = $status;
            $subscription->update();
        }
        return;
    }

    public function getSubscriptionInfo($subscriptionId)
    {
        $response = $this->getSubscription($subscriptionId);
        $subscriptionInfo = collect($response);
        $nextBillingTime = $response->billing_info->next_billing_time;
        return($subscriptionInfo);
    }

    public function getSubscription($subscriptionId)
    {
        return $this->makeRequest(
            'GET',
            "/v1/billing/subscriptions/{$subscriptionId}",
            [],
            [],
            [
                'Content-Type' => 'application/json',
            ],
            $isJsonRequest = true,
        );
    }

    public function handleSubscriptionStatus(Request $request)
    {
        //status
        //0=Suspendida
        //1=Activada
        if ($request->status == 'SUSPENDED') {
            $subscription = $this->activateSubscription(
                $request->subscription_id
            );

            $response = $this->getSubscription($request->subscription_id);
            $subscriptionInfo = collect($response);

            $status = $response->status;
            if($status == 'ACTIVE')
            {
                $nextBillingTime = $response->billing_info->next_billing_time;
                $timestamp = strtotime($nextBillingTime);
                $nextBillingTime = date("Y-m-d H:i:s", $timestamp);
                $subscription = Subscription::where('subscription_id', $request->subscription_id)->first();
                $subscription->next_billing_time = $nextBillingTime;
                $subscription->active_until = $nextBillingTime;
                $subscription->status = $status;
                $subscription->update();
            }

            return redirect('my-account')->with('status',__('La suscripción se activó, se le cobrara automáticamente de acuerdo al plan al que esta suscrito.'));
        }
        if ($request->status == 'ACTIVE') {
            $subscription = $this->suspendSubscription(
                $request->subscription_id
            );

            $response = $this->getSubscription($request->subscription_id);
            $subscriptionInfo = collect($response);

            $status = $response->status;
            if($status == 'SUSPENDED')
            {
                $subscription = Subscription::where('subscription_id', $request->subscription_id)->first();
                $subscription->status = $status;
                $subscription->update();
            }

            return redirect('my-account')->with('status',__('La suscripción se suspendió, puede activarla nuevamente si lo desea.'));
        }

    }

    public function cancelsusbscriptionstatus(Request $request)
    {

        $subscription = $this->cancelSubscription(
            $request->subscription_id
        );
        $subscription = Subscription::where('subscription_id', $request->subscription_id)->first();
        $subscription->delete();

        return redirect('my-account')->with('status',__('La suscripción se cancelo.'));

    }

    public function suspendSubscription($subscriptionId)
    {
        return $this->makeRequest(
            'POST',
            "/v1/billing/subscriptions/{$subscriptionId}/suspend",
            [],
            [
                'reason' => "Suspendido por el usuario",
            ],
            [
                'Content-Type' => 'application/json',
            ],
            true // No es necesario asignar a $isJsonRequest, ya que está implícito
        );
    }

    public function activateSubscription($subscriptionId)
    {
        return $this->makeRequest(
            'POST',
            "/v1/billing/subscriptions/{$subscriptionId}/activate",
            [],
            [
                'reason' => "Activado por el usuario",
            ],
            [
                'Content-Type' => 'application/json',
            ],
            true // No es necesario asignar a $isJsonRequest, ya que está implícito
        );
    }

    public function cancelSubscription($subscriptionId)
    {
        return $this->makeRequest(
            'POST',
            "/v1/billing/subscriptions/{$subscriptionId}/cancel",
            [],
            [
                'reason' => "Cancelado por el usuario",
            ],
            [
                'Content-Type' => 'application/json',
            ],
            true // No es necesario asignar a $isJsonRequest, ya que está implícito
        );
    }
}
