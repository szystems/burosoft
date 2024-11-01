<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Models\PatExpediente;
use App\Http\Requests\PatExpedienteFormRequest;
use App\Models\Cuenta;
use App\Models\Config;
use App\Models\User;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

class PatExpedienteController extends Controller
{
    public function insert(PatExpedienteFormRequest $request)
    {
        $expediente = new PatExpediente();
        if($request->hasFile('archivo'))
        {
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/expedientes',$filename);
            $expediente->archivo = $filename;
            $expediente->tipo = $ext;
        }
        // dd($ext);
        $expediente->pat_id = $request->input('pat_id');
        $expediente->fecha = $request->input('fecha');
        $expediente->usuario_id = $request->input('usuario_id');
        $expediente->nombre = $request->input('nombre');
        $expediente->descripcion = $request->input('descripcion');
        $expediente->save();

        $pat = Pat::find($expediente->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Agrego un nuevo expediente en el pat No.Expediente:".$pat->no_expediente.", Nombre Expediente:".$expediente->nombre,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Expediente agregado exitosamente.'));
    }

    public function update(PatExpedienteFormRequest $request, $id)
    {
        $expediente = PatExpediente::find($id);
        if($request->hasFile('archivo'))
        {
            $path = 'assets/uploads/pat/expedientes'.$expediente->archivo;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/expedientes',$filename);
            $expediente->archivo = $filename;
            $expediente->tipo = $ext;
        }
        $expediente->fecha = $request->input('fecha');
        $expediente->nombre = $request->input('nombre');
        $expediente->descripcion = $request->input('descripcion');
        $expediente->update();

        $pat = Pat::find($expediente->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Actualizo un expediente en el pat No.Expediente:".$pat->no_expediente.", Nombre Expediente:".$expediente->nombre,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Expediente actualizado exitosamente.'));

    }

    public function destroy($id)
    {
        $expediente = PatExpediente::find($id);
        $pat = Pat::find($expediente->pat_id);
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Eliminó un expediente en el pat No.Expediente:".$pat->no_expediente.", Nombre Expediente:".$expediente->nombre,
        ]);
        $expediente->delete();
        return redirect('show-pat/'.$pat->id)->with('status',__('Expediente eliminado exitosamente.'));
    }
}
