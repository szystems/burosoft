<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ConstanciaPagoFormRequest;
use App\Models\ConstanciaPago;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ConstanciaPagoController extends Controller
{
    public function insert(ConstanciaPagoFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            
            // Verificar que el archivo sea válido
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $uploadPath = public_path('uploads/constancia-pagos');
                
                // Crear directorio si no existe
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Mover archivo
                if ($file->move($uploadPath, $filename)) {
                    $data['archivo'] = $filename;
                    $data['tipo_archivo'] = $file->getClientOriginalExtension();
                } else {
                    return redirect()->back()->withErrors(['archivo' => 'Error al subir el archivo.'])->withInput();
                }
            } else {
                return redirect()->back()->withErrors(['archivo' => 'El archivo no es válido.'])->withInput();
            }
        }

        $constanciaPago = ConstanciaPago::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva Constancia de Pago con identificación: ' . $constanciaPago->identificacion .
                             ' para el expediente No.: ' . $constanciaPago->pat->no_expediente .
                             ', cuenta: ' . $constanciaPago->pat->cuenta->codigo . ' - ' . $constanciaPago->pat->cuenta->razon_social
        ]);

        return redirect('show-pat/' . $data['pat_id'])->with('status', 'Constancia de Pago creada exitosamente');
    }

    public function update(ConstanciaPagoFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $constanciaPago = ConstanciaPago::findOrFail($id);

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($constanciaPago->archivo && File::exists(public_path('uploads/constancia-pagos/' . $constanciaPago->archivo))) {
                File::delete(public_path('uploads/constancia-pagos/' . $constanciaPago->archivo));
            }

            $file = $request->file('archivo');
            
            // Verificar que el archivo sea válido
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $uploadPath = public_path('uploads/constancia-pagos');
                
                // Crear directorio si no existe
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Mover archivo
                if ($file->move($uploadPath, $filename)) {
                    $data['archivo'] = $filename;
                    $data['tipo_archivo'] = $file->getClientOriginalExtension();
                } else {
                    return redirect()->back()->withErrors(['archivo' => 'Error al subir el archivo.'])->withInput();
                }
            } else {
                return redirect()->back()->withErrors(['archivo' => 'El archivo no es válido.'])->withInput();
            }
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $constanciaPago->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Constancia de Pago con identificación: ' . $constanciaPago->identificacion .
                             ' para el expediente No.: ' . $constanciaPago->pat->no_expediente .
                             ', cuenta: ' . $constanciaPago->pat->cuenta->codigo . ' - ' . $constanciaPago->pat->cuenta->razon_social
        ]);

        return redirect('show-pat/' . $constanciaPago->pat_id)->with('status', 'Constancia de Pago actualizada exitosamente');
    }

    public function destroy($id)
    {
        $constanciaPago = ConstanciaPago::findOrFail($id);

        // Eliminar archivo si existe
        if ($constanciaPago->archivo && File::exists(public_path('uploads/constancia-pagos/' . $constanciaPago->archivo))) {
            File::delete(public_path('uploads/constancia-pagos/' . $constanciaPago->archivo));
        }

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Constancia de Pago con identificación: ' . $constanciaPago->identificacion .
                             ' del expediente No.: ' . $constanciaPago->pat->no_expediente .
                             ', cuenta: ' . $constanciaPago->pat->cuenta->codigo . ' - ' . $constanciaPago->pat->cuenta->razon_social
        ]);

        $pat_id = $constanciaPago->pat_id;
        $constanciaPago->delete();

        return redirect('show-pat/' . $pat_id)->with('status', 'Constancia de Pago eliminada exitosamente');
    }
}
