<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PaymentPlatform;
use App\Models\Plan;
use App\Resolvers\PaymentPlatformResolver;
use App\Models\Subscription;
use App\Services\PayPalService;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    protected $paymentPlatformResolver;

    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->middleware(['auth', 'unsubscribed']);

        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }

    public function show()
    {
        $paymentPlatforms = PaymentPlatform::where('subscriptions_enabled', true)->get();

        return view('frontend.subscribe')->with(['plans' => Plan::all(), 'paymentPlatforms' => $paymentPlatforms,]);
    }

    public function store(Request $request)
    {
        if (Subscription::where('user_id', $request->user_id)->exists()) {
            return redirect('user-subscription/'.$request->user_id)->with('status',"Ya tienes una suscripción anterior que ya no está activa por falta de pago o inactiva. Puedes Eliminarla desde Suscripciones en tu cuenta para eliminarla e intenta de nuevo suscribirte.");
        }else
        {
            $rules = [
                'plan' => ['required', 'exists:plans,slug'],
                'payment_platform' => ['required', 'exists:payment_platforms,id'],
            ];

            $request->validate($rules);

            $paymentPlatform = $this->paymentPlatformResolver
                ->resolveService($request->payment_platform);

            session()->put('subscriptionPlatformId', $request->payment_platform);

            return $paymentPlatform->handleSubscription($request);
        }

    }

    public function approval(Request $request)
    {
        $rules = [
            'plan' => ['required', 'exists:plans,slug']
        ];

        $request->validate($rules);

        if (session()->has('subscriptionPlatformId')) {
            $paymentPlatform = $this->paymentPlatformResolver
                ->resolveService(session()->get('subscriptionPlatformId'));

            if ($paymentPlatform->validateSubscription($request)) {
                $plan = Plan::where('slug', $request->plan)->firstOrFail();
                $user = $request->user();

                $today = now();
                $addMonths = \Carbon\Carbon::parse($today)->addMonths(3);
                $active_until = $addMonths->format($plan->duration_in_months);



                $subscription = Subscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'subscription_id' => $request->subscription_id
                ]);

                $nextPayment = new PayPalService();
                $nextPayment->getNextPayment($request->subscription_id);


                return redirect()->route('home')->withSuccess(['payment' => "Gracias, {$user->name}. Tu suscripcion {$plan->slug} esta activa."]);
            }


        }

        return redirect()
            ->route('subscribe.show')
            ->withErrors('No podemos comprobar su suscripción. Inténtalo de nuevo, por favor.');

    }

    public function cancelled()
    {
        return redirect()
            ->route('subscribe.show')
            ->withErrors('Has cancelado tu suscripcion. Regresa cuando estés listo :)');
    }

    public function updatestatussub(Request $request)
    {
        dd($request->all());
    }
}
