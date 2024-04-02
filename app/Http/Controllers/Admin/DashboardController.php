<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserCreateFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Config;
use PDF;
use DB;

class DashboardController extends Controller
{
    public function users(Request $request)
    {
        if ($request)
        {
            $queryUser=$request->input('fuser');
            $users=DB::table('users')
            ->where('status','=',1)
            // ->where('name','LIKE','%'.$queryUser.'%')
            // ->orWhere('phone','LIKE','%'.$queryUser.'%')
            ->where('name','LIKE','%'.$queryUser.'%')
            ->orWhere('email','LIKE','%'.$queryUser.'%')
            ->where('status','=',1)
            ->orderBy('name','asc')
            ->paginate(25);
            $filterUsers = User::all();
            return view('admin.user.index', compact('users','queryUser','filterUsers'));
        }
    }

    public function showuser($id)
    {
        $user = User::find($id);
        return view('admin.user.show', compact('user'));
    }

    public function adduser()
    {
        return view('admin.user.add');
    }

    public function insertuser(UserCreateFormRequest $request)
    {
        $user = new User();
        // if($request->hasFile('image'))
        // {
        //     $file = $request->file('image');
        //     $ext = $file->getClientOriginalExtension();
        //     $filename = time().'.'.$ext;
        //     $file->move('assets/uploads/user',$filename);
        //     $user->image = $filename;
        // }
        $user->role_as = $request->input('role_as');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = 'BURO'.rand(1111,9999);
        // $user->phone = $request->input('phone');
        // $user->address1 = $request->input('address1');
        // $user->address2 = $request->input('address2');
        // $user->city = $request->input('city');
        // $user->state = $request->input('state');
        // $user->country = $request->input('country');
        // $user->zipcode = $request->input('zipcode');
        // $user->timezone = $request->input('timezone');
        $user->save();

        return redirect('users')->with('status', __('Usuario agregado correctamente'));
    }

    public function edituser($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', \compact('user'));
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

        if (Auth::id() == $id) {
            return redirect('show-user/'.$id)->with('status',__('Usuario actualizado correctamente'));
        }else{
            return redirect('users')->with('status',__('Usuario actualizado correctamente'));
        }

    }

    public function destroyuser($id)
    {
        $user = User::find($id);
        // if ($user->image)
        // {
        //     $path = 'assets/uploads/category/'.$user->image;
        //     if (File::exists($path))
        //     {
        //         File::delete($path);

        //     }
        // }
        $user = User::find($id);
        $user->status = 0;
        $user->email = $user->email.'-Deleted';
        $user->update();
        return redirect('users')->with('status',__('Usuario eliminado correctamente'));
    }

    public function pdf(Request $request)
    {
        if ($request)
        {
            $user = User::find($request->input('ruser'));

            $verpdf = "Browser";
            $nompdf = date('m/d/Y g:ia');
            $path = public_path('assets/uploads/');

            $config = Config::first();

            $currency = $config->currency_simbol;

            if ($config->logo == null)
            {
                $logo = null;
                $imagen = null;
            }
            else
            {
                    $logo = $config->logo;
                    $imagen = public_path('assets/uploads/logos/'.$logo);
            }


            $config = Config::first();

            if ( $verpdf == "Download" )
            {
                $pdf = PDF::loadView('admin.user.pdf',['user'=>$user,'path'=>$path,'config'=>$config,'imagen'=>$imagen,'currency'=>$currency]);

                return $pdf->download ('User: '.$user->name.$nompdf.'.pdf');
            }
            if ( $verpdf == "Browser" )
            {
                $pdf = PDF::loadView('admin.user.pdf',['user'=>$user,'path'=>$path,'config'=>$config,'imagen'=>$imagen,'currency'=>$currency]);

                return $pdf->stream ('User: '.$user->name.$nompdf.'.pdf');
            }
        }
    }
}
