<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\Config;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\Auth;
use DB;

class UserController extends Controller
{
    public function indexorders()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at','desc')->get();
        $cartProducts = Cart::where('user_id', Auth::id())->get();
        $config = Config::first();
        return view('frontend.orders.index', compact('orders','cartProducts','config'));
    }

    public function indexuser()
    {
        $config = Config::first();
        return view('frontend.user.index', compact('config'));
    }

    public function showuser($id)
    {
        $config = Config::first();
        $user = User::where('id', $id)->first();
        return view('frontend.user.show', compact('user','config'));
    }

    public function edituser($id)
    {
        $config = Config::first();
        $user = User::where('id', $id)->first();
        return view('frontend.user.edit', compact('user','config'));
    }

    public function updateuser(UserFormRequest $request, $id)
    {
        $user = User::find($id);
        // if($request->hasFile('image'))
        // {
        //     $path = 'assets/uploads/category/'.$user->image;
        //     if(File::exists($path))
        //     {
        //         File::delete($path);
        //     }
        //     $file = $request->file('image');
        //     $ext = $file->getClientOriginalExtension();
        //     $filename = time().'.'.$ext;
        //     $file->move('assets/uploads/category',$filename);
        //     $user->image = $filename;
        // }
        $user->name = $request->input('name');
        // $user->phone = $request->input('phone');
        // $user->address1 = $request->input('address1');
        // $user->address2 = $request->input('address2');
        // $user->city = $request->input('city');
        // $user->state = $request->input('state');
        // $user->country = $request->input('country');
        // $user->zipcode = $request->input('zipcode');
        // $user->timezone = $request->input('timezone');
        $user->update();

        return redirect('my-account')->with('status',__('Usuario actualizado correctamente'));
    }

    public function showsubscription($id)
    {
        $config = Config::first();
        $user = User::where('id', $id)->first();
        $subscription = Subscription::where('user_id',$id)->first();
        return view('frontend.user.subscription', compact('user','config','subscription'));
    }
}
