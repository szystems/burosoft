<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;

class SubsController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $queryuser=$request->input('fuser');
            $queryplan=$request->input('fplan');
            $queryisactive=$request->input('fisactive');
            if ($queryisactive == null) {
                $subscriptions=Subscription::join('plans', 'plans.id', '=', 'subscriptions.plan_id')
                ->join('users', 'users.id', '=', 'subscriptions.user_id')
                ->where('users.email','LIKE',$queryuser)
                ->where('subscriptions.plan_id','LIKE','%'.$queryplan.'%')
                ->orderBy('subscriptions.created_at','asc')
                ->get('subscriptions.*','plans.*','users.*');
            }else{
                $subscriptions=Subscription::join('plans', 'plans.id', '=', 'subscriptions.plan_id')
                ->join('users', 'users.id', '=', 'subscriptions.user_id')
                ->where('users.email','LIKE',$queryuser)
                ->where('subscriptions.plan_id','LIKE','%'.$queryplan.'%')
                ->where('subscriptions.active_until',$queryisactive,now())
                ->orderBy('subscriptions.created_at','asc')
                ->get('subscriptions.*','plans.*','users.*');
            }

            $plansFilter = Plan::all();
            $usersFilter = User::where('status',1)->get();
            return view('admin.subscription.index', compact('subscriptions','queryuser','queryplan','queryisactive','plansFilter','usersFilter'));
        }
    }

    public function insert(Request $request)
    {

        if (Subscription::where('user_id', $request->input('user_id'))->exists()) {
            return redirect('index-subscriptions')->with('status', __('Este Usuario ya tiene una suscripción. Puede buscarla en el listado y editarla.'));
        } else {
            $active_until = $request->get('active_until');
            $active_until = date("Y-m-d H:i:s", strtotime($active_until));

            $subscription = new Subscription();
            $subscription->user_id = $request->input('user_id');
            $subscription->plan_id = $request->input('plan_id');
            $subscription->active_until = $active_until;
            $subscription->save();

            return redirect('index-subscriptions')->with('status', __('Suscripción creada correctamente'));
        }
    }

    public function update(Request $request, $id)
    {
        $active_until = $request->get('active_until');
        $active_until = date("Y-m-d H:i:s", strtotime($active_until));

        $subscription = Subscription::find($id);
        $subscription->active_until = $active_until;
        $subscription->update();

        return redirect('index-subscriptions')->with('status', __('Suscripción actualizada correctamente'));
    }

    public function destroy($id)
    {
        $subscription = Subscription::find($id);
        $subscription->delete();
        return redirect('index-subscriptions')->with('status', __('Suscripción eliminada correctamente'));
    }
}
