<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Subscription;
use App\Services\PayPalService;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function authenticated()
    {
        // if (Subscription::where('user_id', Auth::user()->id)->where('plan_id', "!=", 1)->exists()) {
        //     $subscription = Subscription::where('user_id', Auth::user()->id)->first();
        //         $nextPayment = new PayPalService();
        //         $nextPayment->getNextPayment($subscription->subscription_id);
        // }elseif (Subscription::where('user_id', Auth::user()->id)->where('plan_id', "=", 1)->where('active_until', '<', now())->exists()) {
        //     $subscription = Subscription::where('user_id', Auth::user()->id)->first();
        //     $subscription->delete();
        // }
        if(Auth::user()->role_as == '0') //1 = Admin Login
        {
            return redirect('dashboard')->with('status','Bienvenido a tu panel de control');
        }
        elseif(Auth::user()->role_as == '1') // Normal or Default User Login
        {
            return redirect('dashboard')->with('status', 'Bienvenido a tu panel de control de empresa');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
