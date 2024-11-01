<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Models\PatNotificacion;
use App\Http\Requests\PatNotificacionFormRequest;
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

class PatNotificacionController extends Controller
{
    public function insert(PatNotificacionFormRequest $request)
    {
        // dd($request->all());
        $vencimiento_plazo = date("Y-m-d", strtotime($request->vencimiento_plazo));

        $notificacion = new PatNotificacion();
        if($request->hasFile('archivo'))
        {
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/notificaciones',$filename);
            $notificacion->archivo = $filename;
            $notificacion->tipo = $ext;
        }
        // dd($ext);
        $notificacion->pat_id = $request->input('pat_id');
        $notificacion->usuario_id = $request->input('usuario_id');
        $notificacion->fecha = $request->input('fecha');
        $notificacion->hora = $request->input('hora');
        $notificacion->tipo_notificacion = $request->input('tipo_notificacion');
        $notificacion->recibio = $request->input('recibio');
        $notificacion->domicilio_notificacion = $request->input('domicilio_notificacion');
        $notificacion->domicilio_notificacion_es = $request->input('domicilio_notificacion_es');
        $notificacion->domicilio_notificacion_otro = $request->input('domicilio_notificacion_otro');
        $notificacion->persona_idonea = $request->input('persona_idonea');
        $notificacion->folios_notificados = $request->input('folios_notificados');
        $notificacion->acto_notificado = $request->input('acto_notificado');
        $notificacion->plazo_atencion = $request->input('plazo_atencion');
        $notificacion->vencimiento_plazo = $vencimiento_plazo;
        $notificacion->save();

        $pat = Pat::find($notificacion->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Agrego una nueva notificacion en el pat No.Expediente:".$pat->no_expediente.", Acto Notificado:".$notificacion->acto_notificado,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Notificacion agregada exitosamente.'));
    }

    public function update(PatNotificacionFormRequest $request, $id)
    {
        $vencimiento_plazo = date("Y-m-d", strtotime($request->vencimiento_plazo));

        $notificacion = PatNotificacion::find($id);
        if($request->hasFile('archivo'))
        {
            $path = 'assets/uploads/pat/notificaciones'.$notificacion->archivo;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/notificaciones',$filename);
            $notificacion->archivo = $filename;
            $notificacion->tipo = $ext;
        }
        $notificacion->tipo_notificacion = $request->input('tipo_notificacion');
        $notificacion->fecha = $request->input('fecha');
        $notificacion->hora = $request->input('hora');
        $notificacion->recibio = $request->input('recibio');
        $notificacion->domicilio_notificacion = $request->input('domicilio_notificacion');
        $notificacion->domicilio_notificacion_es = $request->input('domicilio_notificacion_es');
        $notificacion->domicilio_notificacion_otro = $request->input('domicilio_notificacion_otro');
        $notificacion->persona_idonea = $request->input('persona_idonea');
        $notificacion->folios_notificados = $request->input('folios_notificados');
        $notificacion->acto_notificado = $request->input('acto_notificado');
        $notificacion->plazo_atencion = $request->input('plazo_atencion');
        $notificacion->vencimiento_plazo = $vencimiento_plazo;
        $notificacion->update();

        $pat = Pat::find($notificacion->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Actualizo una notificacion en el pat No.Expediente:".$pat->no_expediente.", Acto Notificado:".$notificacion->acto_notificado,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Notificacion actualizada exitosamente.'));

    }

    public function destroy($id)
    {
        $notificacion = PatNotificacion::find($id);
        $pat = Pat::find($notificacion->pat_id);
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Eliminó una notificacion en el pat No.Expediente:".$pat->no_expediente.", Acto Notificado:".$notificacion->acto_notificado,
        ]);
        $notificacion->delete();
        return redirect('show-pat/'.$pat->id)->with('status',__('Notificacion eliminada exitosamente.'));
    }
}
