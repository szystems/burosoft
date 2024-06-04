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
        $pago->save();

        $movimiento = Movimiento::find($pago->movimiento_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Movimiento",
            'descripcion' => "Agrego un nuevo Pago: Q.".number_format($movimiento->monto_q,2, '.', ',') .", Movimiento: ".$movimiento->id."Forma Pago: ".$movimiento->forma_pago,
        ]);

        return redirect('show-movimiento/'.$movimiento->id)->with('status',__('Pago agregado exitosamente.'));
    }

    public function update(MovimientoPagoFormRequest $request, $id)
    {
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
        $pago->update();

        $movimiento = Movimiento::find($pago->movimiento_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Movimiento",
            'descripcion' => "Actualizo un Pago: Q.".number_format($movimiento->monto_q,2, '.', ',') .", Movimiento: ".$movimiento->id."Forma Pago: ".$movimiento->forma_pago,
        ]);

        return redirect('show-movimiento/'.$movimiento->id)->with('status',__('Pago actualizado exitosamente.'));

    }

    public function destroy($id)
    {
        $pago = MovimientoPago::find($id);
        $movimiento = Movimiento::find($pago->movimiento_id);
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Cuenta",
            'descripcion' => "Eliminó un pago: Q.".number_format($movimiento->monto_q,2, '.', ',') .", Movimiento: ".$movimiento->id."Forma Pago: ".$movimiento->forma_pago,
        ]);
        $pago->delete();
        return redirect('show-movimiento/'.$movimiento->id)->with('status',__('Pago eliminado exitosamente.'));
    }
}
