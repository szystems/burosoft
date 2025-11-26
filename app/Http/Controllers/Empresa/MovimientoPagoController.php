<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MovimientoPago;
use App\Http\Requests\MovimientoPagoFormRequest;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Config;
use App\Models\Bitacora;
use Carbon\Carbon;
use PDF;
use DB;

class MovimientoPagoController extends Controller
{
    public function insert(MovimientoPagoFormRequest $request)
    {
        $fecha_documento = date("Y-m-d", strtotime($request->fecha_documento));
        $movimiento = Movimiento::find($request->input('movimiento_id'));

        $pago = new MovimientoPago();
        if($request->hasFile('imagen'))
        {
            $file = $request->file('imagen');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pagos',$filename);
            $pago->imagen = $filename;
        }
        $pago->movimiento_id = $request->input('movimiento_id');
        $pago->descripcion = $request->input('descripcion');
        $pago->forma_pago = $request->input('forma_pago');
        $pago->usuario_id = $request->input('usuario_id');
        $pago->monto_q = $request->input('monto_q');
        $pago->monto_d = $request->input('monto_d');
        $pago->numero_documento = $request->input('numero_documento');
        $pago->banco = $request->input('banco');
        $pago->numero_cuenta = $request->input('numero_cuenta');
        $pago->fecha_documento = $fecha_documento;

        // Agregar el campo estado
        $pago->estado = 1;

        // Generar el código
        $empresa_id = $movimiento->empresa_id;
        // dd($empresa_id);
        $cuenta_id = $movimiento->cuenta_id;
        $movimiento_id = $movimiento->id;

        // Obtener el correlativo
        $correlativo = MovimientoPago::where('movimiento_id', $movimiento_id)->count() + 1; // Incrementar para el siguiente correlativo

        // Formar el código
        $pago->codigo = "{$movimiento->codigo}-P{$correlativo}";

        $pago->save();

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Movimiento",
            'descripcion' => "Agrego un nuevo Pago: Q.".number_format($movimiento->monto_q,2, '.', ',') .", Movimiento: ".$movimiento->id.", Forma Pago: ".$movimiento->forma_pago,
        ]);

        return redirect('show-movimiento/'.$movimiento->id)->with('status',__('Pago agregado exitosamente.'));
    }

    public function update(MovimientoPagoFormRequest $request, $id)
    {
        $fecha_documento = date("Y-m-d", strtotime($request->fecha_documento));
        $pago = MovimientoPago::find($id);
        if($request->hasFile('imagen'))
        {
            $path = 'assets/uploads/pagos/'.$pago->imagen;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('imagen');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pagos',$filename);
            $pago->imagen = $filename;
        }
        $pago->descripcion = $request->input('descripcion');
        $pago->forma_pago = $request->input('forma_pago');
        $pago->usuario_id = $request->input('usuario_id');
        $pago->monto_q = $request->input('monto_q');
        $pago->monto_d = $request->input('monto_d');
        $pago->numero_documento = $request->input('numero_documento');
        $pago->banco = $request->input('banco');
        $pago->numero_cuenta = $request->input('numero_cuenta');
        $pago->fecha_documento = $fecha_documento;
        $pago->update();

        $movimiento = Movimiento::find($pago->movimiento_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Movimiento",
            'descripcion' => "Actualizo un Pago: Q.".number_format($movimiento->monto_q,2, '.', ',') .", Movimiento: ".$movimiento->id.", Forma Pago: ".$movimiento->forma_pago,
        ]);

        return redirect('show-movimiento/'.$movimiento->id)->with('status',__('Pago actualizado exitosamente.'));

    }

    public function destroy($id)
{
    $pago = MovimientoPago::find($id);
    $movimiento = Movimiento::find($pago->movimiento_id);

    // Cambiar el estado a 0 en lugar de eliminar el registro
    $pago->estado = 0;
    $pago->save(); // Guardar el cambio en la base de datos

    Bitacora::create([
        'empresa_id' => Auth::user()->empresa_id,
        'usuario_id' => Auth::user()->id,
        'fecha' => now(),
        'tipo' => "Movimiento",
        'descripcion' => "Desactivó un pago: Q.".number_format($movimiento->monto_q,2, '.', ',') .", Movimiento: ".$movimiento->id.", Forma Pago: ".$movimiento->forma_pago,
    ]);

    return redirect('show-movimiento/'.$movimiento->id)->with('status',__('Pago desactivado exitosamente.'));
}

    public function destroyimg($id)
    {
        $pago = MovimientoPago::find($id);
        $movimiento = Movimiento::find($pago->movimiento_id);

            $path = 'assets/uploads/pagos/'.$pago->imagen;
            if(File::exists($path))
            {
                File::delete($path);
            }
        $pago->imagen = null;
        $pago->update();

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Movimiento",
            'descripcion' => "Eliminó la imagen de un pago: Q.".number_format($movimiento->monto_q,2, '.', ',') .", Movimiento: ".$movimiento->id.", Forma Pago: ".$movimiento->forma_pago,
        ]);

        return redirect('show-movimiento/'.$movimiento->id)->with('status',__('Imagen de pago eliminada exitosamente.'));
    }

    public function pdfpago(Request $request, $id)
    {
        if ($request)
        {
            $verpdf = "Browser";
            $nompdf = date('Y-m-d_H-i-s');
            $path = public_path('assets/uploads/');

            $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();
            $pago = MovimientoPago::find($id);
            $movimiento = Movimiento::find($pago->movimiento_id);
            $totalAbonadoQ = MovimientoPago::where('movimiento_id', $pago->movimiento_id)->where('estado', 1)->sum('monto_q');
            $totalAbonadoD = MovimientoPago::where('movimiento_id', $pago->movimiento_id)->where('estado', 1)->sum('monto_d');

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


            $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();

            if ( $verpdf == "Download" )
            {
                $pdf = PDF::loadView('empresa.movimiento.pdfpago',['pago'=>$pago,'movimiento'=>$movimiento,'path'=>$path,'config'=>$config,'imagen'=>$imagen,'currency'=>$currency,'totalAbonadoQ'=>$totalAbonadoQ,'totalAbonadoD'=>$totalAbonadoD]);

                return $pdf->download ('pago: '.$movimiento->id.'-'.$pago->id.'-'.$nompdf.'.pdf');
            }
            if ( $verpdf == "Browser" )
            {
                $pdf = PDF::loadView('empresa.movimiento.pdfpago',['pago'=>$pago,'movimiento'=>$movimiento,'path'=>$path,'config'=>$config,'imagen'=>$imagen,'currency'=>$currency,'totalAbonadoQ'=>$totalAbonadoQ,'totalAbonadoD'=>$totalAbonadoD]);

                return $pdf->stream ('pago: '.$movimiento->id.'-'.$pago->id.'-'.$nompdf.'.pdf');
            }
        }
    }
}
