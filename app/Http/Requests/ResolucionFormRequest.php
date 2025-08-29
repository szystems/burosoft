<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResolucionFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fecha_notificacion' => 'required|date_format:Y-m-d\TH:i',
            'fecha_resolucion' => 'nullable|date',
            'fecha' => 'nullable|date', // Campo generado automáticamente por prepareForValidation
            'numero_resolucion' => 'required|string|max:255',
            'tipo_resolucion' => 'required|in:total a favor,total en contra,parcial,nulidad,penal,otro',
            'tipo_resolucion_otro' => 'nullable|required_if:tipo_resolucion,otro|string|max:255',
            'plazo_revocatoria' => 'nullable|in:5 D.H.,10 D.H.,30 D.H.,otro',
            'plazo_revocatoria_otro' => 'nullable|required_if:plazo_revocatoria,otro|string|max:255',
            'usuario_id' => 'required|exists:users,id',
            'audiencia_id' => 'required|exists:audiencias,id',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Mantener compatibilidad: si no se envía fecha_notificacion pero sí fecha, usar fecha
        if (!$this->has('fecha_notificacion') && $this->has('fecha')) {
            $this->merge([
                'fecha_notificacion' => $this->fecha
            ]);
        }
        
        // Mantener el campo fecha para compatibilidad con el modelo
        if ($this->has('fecha_notificacion')) {
            $this->merge([
                'fecha' => date('Y-m-d', strtotime($this->fecha_notificacion))
            ]);
        }
    }
}
