<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatNotificacionFormRequest extends FormRequest
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
            'pat_id' => 'required|integer',
            'tipo_notificacion' => 'required|string',
            'recibio' => 'required|string',
            'domicilio_notificacion' => 'required|string',
            'acto_notificado' => 'required|string',
            'plazo_atencion' => 'required|string',
            'vencimiento_plazo' => 'required|date',
        ];
    }
}
