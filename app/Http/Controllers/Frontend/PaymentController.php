<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PayPalService;
use App\Models\Subscription;
use App\Resolvers\PaymentPlatformResolver;

class PaymentController extends Controller
{
    protected $paymentPlatformResolver;

    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->middleware('auth');

        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }

    public function pay(Request $request)
    {
        $rules = [
            'value' => ['required', 'numeric', 'min:5'],
            'currency' => ['required', 'exists:currencies,iso'],
            'payment_platform' => ['required', 'exists:payment_platforms,id'],
        ];

        // dd($request->all());

        $request->validate($rules);

        $paymentPlatform = $this->paymentPlatformResolver->resolveService($request->payment_platform);

        session()->put('paymentPlatformId', $request->payment_platform);

        // if ($request->user()->hasActiveSubscription()) {
        //     $request->value = round($request->value * 0.9, 2);
        // }

        return $paymentPlatform->handlePayment($request);
    }

    public function approval()
    {
        if (session()->has('paymentPlatformId')) {
            $paymentPlatform = $this->paymentPlatformResolver
                ->resolveService(session()->get('paymentPlatformId'));

            return $paymentPlatform->handleApproval();
        }

        return redirect()
            ->route('home')
            ->withErrors('No podemos recuperar su plataforma de pago. Por favor inténtalo de nuevo.');
    }

    public function cancelled()
    {
        return redirect()
            ->route('home')
            ->withErrors('Has cancelado el pago.');
    }

    public function updatestatussub(Request $request)
    {
        $rules = [
            'subscription_id' => ['required'],
            'payment_platform' => ['required', 'exists:payment_platforms,id'],
            'status' => ['required'],
        ];

        $request->validate($rules);

        $paymentPlatform = $this->paymentPlatformResolver
            ->resolveService($request->payment_platform);

        session()->put('subscriptionPlatformId', $request->payment_platform);

        return $paymentPlatform->handleSubscriptionStatus($request);
    }

    public function cancelsub(Request $request)
    {
        $rules = [
            'subscription_id' => ['required'],
            'payment_platform' => ['required', 'exists:payment_platforms,id']
        ];

        $request->validate($rules);

        $paymentPlatform = $this->paymentPlatformResolver
            ->resolveService($request->payment_platform);

        session()->put('subscriptionPlatformId', $request->payment_platform);

        return $paymentPlatform->cancelsusbscriptionstatus($request);
    }

    public function cancelsubgratis(Request $request)
    {
        $subscription = Subscription::where('subscription_id', $request->subscription_id)->first();
        $subscription->delete();

        return redirect('my-account')->with('status',__('La suscripción se cancelo.'));
    }
}
