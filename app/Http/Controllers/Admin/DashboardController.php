<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Config;
use Carbon\Carbon;
use PDF;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;

class DashboardController extends Controller
{
    public function users(Request $request)
    {
        if ($request)
        {
            $queryUser=$request->input('fuser');
            $users = DB::table('users')
            ->where('estado', '=', 1)
            ->where('role_as', '=', 0)
            ->where(function ($query) use ($queryUser) {
            $query->where('name', 'LIKE', '%' . $queryUser . '%')
                ->orWhere('email', 'LIKE', '%' . $queryUser . '%')
                ->orWhere('telefono', 'LIKE', '%' . $queryUser . '%')
                ->orWhere('celular', 'LIKE', '%' . $queryUser . '%');
            })
            ->orderBy('name','asc')
            ->paginate(20);
            $filterUsers = User::all();
            return view('admin.user.index', compact('users','queryUser','filterUsers'));
        }
    }

    public function showuser(Request $request, $id)
    {
        $user = User::find($id);

        return view('admin.user.show', compact('user'));
    }

    public function adduser()
    {
        return view('admin.user.add');
    }

    public function insertuser(UserFormRequest $request)
    {
        $user = new User();
        $user->empresa_id = 1;
        if($request->hasFile('fotografia'))
        {
            $file = $request->file('fotografia');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/users',$filename);
            $user->fotografia = $filename;
        }
        $user->role_as = 0;
        $user->estado = 1;
        $user->principal = 1;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = 'Flebo'.rand(1111,9999);
        $user->telefono = $request->input('telefono');
        $user->celular = $request->input('celular');
        $user->direccion = $request->input('direccion');
        $user->save();

        // Mail::to($user->email)->send(new UserMail($user));

        return redirect('show-user/'.$user->id)->with('status',__('Usuario agregado correctamente!'));
    }

    public function edituser($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', \compact('user'));
    }

    public function updateuser(UserFormRequest $request, $id)
    {
        $user = User::find($id);
        if($request->hasFile('fotografia'))
        {
            $path = 'assets/uploads/users/'.$user->fotografia;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('fotografia');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/users',$filename);
            $user->fotografia = $filename;
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->telefono = $request->input('telefono');
        $user->celular = $request->input('celular');
        $user->direccion = $request->input('direccion');
        $user->update();

        return redirect('show-user/'.$id)->with('status',__('Usuario actualizado correctamente!'));
    }

    public function destroyuser($id)
    {
        $user = User::find($id);
        if ($user->fotografia)
        {
            $path = 'assets/img/users/'.$user->fotografia;
            if (File::exists($path))
            {
                File::delete($path);

            }
        }
        $user->estado = 0;
        $user->email = $user->email.'-Deleted'.$user->id;
        $user->update();
        return redirect('users')->with('status',__('Usuario eliminado correctamente!'));
    }
}
