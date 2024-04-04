<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Empresa;
use App\Http\Requests\EmpresaFormRequest;
use Illuminate\Support\Facades\File;
use DB;

class EmpresaInfoController extends Controller
{
    public function show($id)
    {
        $empresa = Empresa::find($id);
        return view('empresa.empresa.show', compact('empresa'));
    }

    public function edit($id)
    {
        $empresa = Empresa::find($id);
        return view('empresa.empresa.edit', \compact('empresa'));
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
        return redirect('show-empresa-info/'.$id)->with('status',__('Empresa actualizada correctamente.'));

    }
}
