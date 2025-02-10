<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Models\Empresa;
use App\Models\Config;
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
        $empresa = Empresa::where('id',  Auth::user()->empresa_id)->first();
        $config = Config::where('empresa_id', $empresa->id)->first();

        $today = now();
        $fecha_vencimiento = $empresa->fecha_vencimiento;
        $fecha_gracia = date("Y-m-d", strtotime("+".$config->gracia." months", strtotime($fecha_vencimiento)));

        if (($fecha_gracia < $today) and ($empresa->id != 1))  {
            Auth::logout();
            return redirect()->back()->withErrors(['license_expired' => 'Tu licencia y periodo de gracia expiro, porfavor ponte en contacto con el personal de Buro para renovar tu licencia.']);
        }

        if(Auth::user()->role_as == '0') //0 = Admin Login
        {
            return redirect('dashboard')->with('status','Bienvenido al panel de Administrador');
        }
        elseif(Auth::user()->role_as == '1') // Normal or Default User Login
        {
            return redirect('empresa-dashboard')->with('status', 'Bienvenido al panel de empresa');
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
