<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Models\PatRct;
use App\Http\Requests\PatRctFormRequest;
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

class PatRctController extends Controller
{
    public function insert(PatRctFormRequest $request)
    {
        $rct = new PatRct();
        
        // Manejar archivo del acta si se suscribe acta = "Si"
        if($request->input('suscribe_acta') == 'Si' && $request->hasFile('archivo_acta'))
        {
            $file = $request->file('archivo_acta');
            $ext = $file->getClientOriginalExtension();
            $filename = 'acta_'.time().'.'.$ext;
            $file->move('assets/uploads/pat/rcts',$filename);
            $rct->archivo_acta = $filename;
            $rct->tipo_archivo_acta = $ext;
        }

        // Manejar archivo del recibo de pago (opcional)
        if($request->hasFile('archivo_recibo_pago'))
        {
            $file = $request->file('archivo_recibo_pago');
            $ext = $file->getClientOriginalExtension();
            $filename = 'recibo_'.time().'.'.$ext;
            $file->move('assets/uploads/pat/rcts',$filename);
            $rct->archivo_recibo_pago = $filename;
            $rct->tipo_archivo_recibo = $ext;
        }

        $rct->pat_id = $request->input('pat_id');
        $rct->usuario_id = $request->input('usuario_id');
        $rct->fecha_citacion = $request->input('fecha_citacion');
        $rct->medio_citacion = $request->input('medio_citacion');
        $rct->medio_citacion_otro = $request->input('medio_citacion_otro');
        $rct->fecha_atencion = $request->input('fecha_atencion');
        $rct->participantes_reunion = $request->input('participantes_reunion');
        $rct->lugar_celebracion = $request->input('lugar_celebracion');
        $rct->descripcion_resultado = $request->input('descripcion_resultado');
        $rct->suscribe_acta = $request->input('suscribe_acta');
        $rct->save();

        $pat = Pat::find($rct->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Agregó una nueva RCT en el pat No.Expediente:".$pat->no_expediente.", Lugar:".$rct->lugar_celebracion,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('RCT agregada exitosamente.'));
    }

    public function update(PatRctFormRequest $request, $id)
    {
        $rct = PatRct::find($id);

        // Manejar archivo del acta si se suscribe acta = "Si"
        if($request->input('suscribe_acta') == 'Si' && $request->hasFile('archivo_acta'))
        {
            if($rct->archivo_acta) {
                $path = 'assets/uploads/pat/rcts/'.$rct->archivo_acta;
                if(File::exists($path))
                {
                    File::delete($path);
                }
            }
            $file = $request->file('archivo_acta');
            $ext = $file->getClientOriginalExtension();
            $filename = 'acta_'.time().'.'.$ext;
            $file->move('assets/uploads/pat/rcts',$filename);
            $rct->archivo_acta = $filename;
            $rct->tipo_archivo_acta = $ext;
        }

        // Manejar archivo del recibo de pago (opcional)
        if($request->hasFile('archivo_recibo_pago'))
        {
            if($rct->archivo_recibo_pago) {
                $path = 'assets/uploads/pat/rcts/'.$rct->archivo_recibo_pago;
                if(File::exists($path))
                {
                    File::delete($path);
                }
            }
            $file = $request->file('archivo_recibo_pago');
            $ext = $file->getClientOriginalExtension();
            $filename = 'recibo_'.time().'.'.$ext;
            $file->move('assets/uploads/pat/rcts',$filename);
            $rct->archivo_recibo_pago = $filename;
            $rct->tipo_archivo_recibo = $ext;
        }

        $rct->fecha_citacion = $request->input('fecha_citacion');
        $rct->medio_citacion = $request->input('medio_citacion');
        $rct->medio_citacion_otro = $request->input('medio_citacion_otro');
        $rct->fecha_atencion = $request->input('fecha_atencion');
        $rct->participantes_reunion = $request->input('participantes_reunion');
        $rct->lugar_celebracion = $request->input('lugar_celebracion');
        $rct->descripcion_resultado = $request->input('descripcion_resultado');
        $rct->suscribe_acta = $request->input('suscribe_acta');
        $rct->update();

        $pat = Pat::find($rct->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Actualizó una RCT en el pat No.Expediente:".$pat->no_expediente.", Lugar:".$rct->lugar_celebracion,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('RCT actualizada exitosamente.'));
    }

    public function destroy($id)
    {
        $rct = PatRct::find($id);
        $pat = Pat::find($rct->pat_id);
        
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Eliminó una RCT en el pat No.Expediente:".$pat->no_expediente.", Lugar:".$rct->lugar_celebracion,
        ]);

        // Eliminar archivos si existen
        if($rct->archivo_acta) {
            $path = 'assets/uploads/pat/rcts/'.$rct->archivo_acta;
            if(File::exists($path))
            {
                File::delete($path);
            }
        }

        if($rct->archivo_recibo_pago) {
            $path = 'assets/uploads/pat/rcts/'.$rct->archivo_recibo_pago;
            if(File::exists($path))
            {
                File::delete($path);
            }
        }

        $rct->delete();
        return redirect('show-pat/'.$pat->id)->with('status',__('RCT eliminada exitosamente.'));
    }
}
