<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AudienciaFormRequest extends FormRequest
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
            'pat_id'             => 'required|integer',
            'usuario_id'         => 'required|integer',
            'numero_audiencia'   => 'required|string',
            'tipo_audiencia'     => 'required|in:AEC,AIR,AS,AA',
            'fecha'              => 'required|date',
            'impuestos'          => 'required|numeric',
            'fecha_notificacion' => 'nullable|date',
            'plazo_evacuar'      => 'nullable|string|max:255',
            'plazo_evacuar_otro' => 'nullable|string|max:255|required_if:plazo_evacuar,Otro',
        ];
    }
}
