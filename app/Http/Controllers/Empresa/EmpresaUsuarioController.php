<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Empresa;
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

class EmpresaUsuarioController extends Controller
{
    public function usuarios(Request $request)
    {
        if ($request)
        {
            $queryUser=$request->input('fuser');
            $users = DB::table('users')
            ->where('estado', '=', 1)
            ->where('empresa_id', '=', Auth::user()->empresa_id)
            ->where(function ($query) use ($queryUser) {
            $query->where('name', 'LIKE', '%' . $queryUser . '%')
                ->orWhere('email', 'LIKE', '%' . $queryUser . '%')
                ->orWhere('telefono', 'LIKE', '%' . $queryUser . '%')
                ->orWhere('celular', 'LIKE', '%' . $queryUser . '%');
            })
            ->orderBy('name','asc')
            ->paginate(20);
            $filterUsers = User::where('empresa_id', Auth::user()->empresa_id);
            return view('empresa.usuario.index', compact('users','queryUser','filterUsers'));
        }
    }

    public function showusuario(Request $request, $id)
    {
        $user = User::find($id);

        return view('empresa.usuario.show', compact('user'));
    }

    public function editusuario($id)
    {
        $user = User::find($id);
        $empresas = Empresa::where('estado', '=', 1)->orderBy('nombre')->get();
        return view('empresa.usuario.edit', \compact('user', 'empresas'));
    }

    public function updateusuario(UserFormRequest $request, $id)
    {
        $user = User::find($id);
        $user->empresa_id = $request->input('empresa_id');
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

        return redirect('show-empresa-usuario/'.$id)->with('status',__('Usuario actualizado correctamente!'));
    }
}
