<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Http\Requests\EmpresaFormRequest;
use Illuminate\Support\Facades\File;
use DB;

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $queryEmpresa=$request->input('fempresa');
            $empresas = DB::table('empresas')
            ->where('estado', '=', 1)
            ->where(function ($query) use ($queryEmpresa) {
            $query->where('nombre', 'LIKE', '%' . $queryEmpresa . '%')
                ->orWhere('email', 'LIKE', '%' . $queryEmpresa . '%')
                ->orWhere('telefono', 'LIKE', '%' . $queryEmpresa . '%')
                ->orWhere('celular', 'LIKE', '%' . $queryEmpresa . '%');
            })
            ->paginate(20);
            $filterEmpresas = Empresa::all();
            return view('admin.empresa.index', compact('empresas','queryEmpresa','filterEmpresas'));
        }
    }

    public function show($id)
    {
        $empresa = Empresa::find($id);
        return view('admin.empresa.show', compact('empresa'));
    }

    public function add()
    {
        return view('admin.empresa.add');
    }

    public function insert(EmpresaFormRequest $request)
    {
        $empresa = new Empresa();
        $fecha_vencimiento = $request->get('fecha_vencimiento');
        $fecha_vencimiento = date("Y-m-d", strtotime($fecha_vencimiento));
        if($request->hasFile('fotografia'))
        {
            $file = $request->file('fotografia');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/empresas',$filename);
            $empresa->fotografia = $filename;
        }
        $empresa->nombre = $request->input('nombre');
        $empresa->direccion = $request->input('direccion');
        $empresa->telefono = $request->input('telefono');
        $empresa->celular = $request->input('celular');
        $empresa->email = $request->input('email');
        $empresa->descripcion = $request->input('descripcion');
        $empresa->fecha_vencimiento = $fecha_vencimiento;
        $empresa->estado = 1;
        $empresa->save();

        // return redirect('empresas')->with('status', __('Empresa agregada exitosamente.'));
        return redirect('show-empresa/'.$empresa->id)->with('status',__('Empresa agregada exitosamente.'));
    }

    public function edit($id)
    {
        $empresa = Empresa::find($id);
        return view('admin.empresa.edit', \compact('empresa'));
    }

    public function update(EmpresaFormRequest $request, $id)
    {
        $empresa = Empresa::find($id);
        $fecha_vencimiento = $request->get('fecha_vencimiento');
        $fecha_vencimiento = date("Y-m-d", strtotime($fecha_vencimiento));
        if($request->hasFile('fotografia'))
        {
            $path = 'assets/uploads/empresas/'.$empresa->fotografia;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('fotografia');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/empresas',$filename);
            $empresa->fotografia = $filename;
        }
        $empresa->nombre = $request->input('nombre');
        $empresa->direccion = $request->input('direccion');
        $empresa->telefono = $request->input('telefono');
        $empresa->celular = $request->input('celular');
        $empresa->email = $request->input('email');
        $empresa->descripcion = $request->input('descripcion');
        $empresa->fecha_vencimiento = $fecha_vencimiento;
        $empresa->update();
        return redirect('show-empresa/'.$id)->with('status',__('Empresa actualizada correctamente.'));

    }

    public function destroy($id)
    {
        $empresa = Empresa::find($id);
        $empresa->estado = 0;
        $empresa->update();
        return redirect('empresas')->with('status',__('Empresa eliminada correctamente.'));
    }
}
