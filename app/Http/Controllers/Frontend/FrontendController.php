<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Config;
use App\Models\Currency;
use App\Models\PaymentPlatform;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contacto;
use Session;
use DB;
use Agent;

class FrontendController extends Controller
{
    public function index()
    {


        return view('frontend.index');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function teachers()
    {
        $teachers = Instructor::all();
        return view('frontend.teachers', compact('teachers'));
    }



    public function contact()
    {
        return view('frontend.contact');
    }

    public function sendcontact(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $subject = $request->input('subject');
        $mensaje = $request->input('mensaje');

        $config = Config::where('empresa_id', 1)->first();
        $mail_to = $config->email;

        Mail::to($mail_to)->send(new Contacto($name,$email,$subject,$mensaje,$mail_to,$config));

        Session::flash('message', 'Gracias por contactarte, pronto nos comunicaremos contigo.');
        Session::flash('alert-class', 'alert-success');

        return view('frontend.contact', compact('config'))->with('status',"Mensaje enviado.");
    }

    public function checkout()
    {
        $currencies = Currency::all();
        $paymentPlatforms = PaymentPlatform::all();
        return view('frontend.checkout', compact('currencies','paymentPlatforms'));
    }




}
