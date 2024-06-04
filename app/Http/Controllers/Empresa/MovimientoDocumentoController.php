<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MovimientoDocumento;
use App\Http\Requests\MovimientoDocumentoFormRequest;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Config;
use App\Models\Bitacora;
use Carbon\Carbon;
use PDF;
use DB;

class MovimientoDocumentoController extends Controller
{

    public function insert(MovimientoDocumentoFormRequest $request)
    {
        $documento = new MovimientoDocumento();
        if($request->hasFile('archivo'))
        {
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/documentos',$filename);
            $documento->archivo = $filename;
        }
        // dd($ext);
        $documento->movimiento_id = $request->input('movimiento_id');
        $documento->usuario_id = $request->input('usuario_id');
        $documento->nombre = $request->input('nombre');
        $documento->tipo = $ext;
        $documento->descripcion = $request->input('descripcion');
        $documento->save();

        $movimiento = Movimiento::find($documento->movimiento_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Movimiento",
            'descripcion' => "Agrego un nuevo Documento: ".$documento->nombre.", Movimiento: ".$movimiento->id,
        ]);

        return redirect('show-movimiento/'.$movimiento->id)->with('status',__('Documento agregado exitosamente.'));
    }

    public function update(MovimientoDocumentoFormRequest $request, $id)
    {
        $documento = MovimientoDocumento::find($id);
        if($request->hasFile('archivo'))
        {
            $path = 'assets/uploads/documentos/'.$documento->archivo;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/documentos',$filename);
            $documento->archivo = $filename;
            $documento->tipo = $ext;
        }
        $documento->nombre = $request->input('nombre');
        $documento->descripcion = $request->input('descripcion');
        $documento->usuario_id = $request->input('usuario_id');
        $documento->update();

        $movimiento = Movimiento::find($documento->movimiento_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Movimiento",
            'descripcion' => "Actualizo un Documento: ".$documento->nombre.", Movimiento: ".$movimiento->id,
        ]);

        return redirect('show-movimiento/'.$movimiento->id)->with('status',__('Documento actualizado exitosamente.'));

    }

    public function destroy($id)
    {
        $documento = MovimientoDocumento::find($id);
        $movimiento = Movimiento::find($documento->movimiento_id);
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Cuenta",
            'descripcion' => "Eliminó un documento: ".$documento->nombre.", Movimiento: ".$movimiento->id,
        ]);
        $documento->delete();
        return redirect('show-movimiento/'.$movimiento->id)->with('status',__('Documento eliminado exitosamente.'));
    }
}
