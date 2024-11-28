<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatAtencionRequerimientoFormRequest extends FormRequest
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
            'pat_id' => 'required|exists:pats,id',
            'no' => 'required|string|max:50',
            'fecha' => 'required|date',
            'forma_atencion' => 'required|in:Escrito,Verbal,Otro',
            'forma_atencion_otro' => 'nullable|string|max:100',
            'entregado_en' => 'required|in:Ventanilla,Actuante,Otros',
            'entregado_en_otro' => 'nullable|string|max:100',
            'oficio_respuesta' => 'required|in:Si,No',
            'acta_administrativa' => 'required|in:Si,No',
            'quien_atendio' => 'required|string|max:50',
            'observaciones' => 'nullable|string',
            'archivo' => 'nullable|max:3000',
            'tipo' => 'nullable|string|max:50',
            'usuario_id' => 'required|exists:users,id',
        ];
    }
}
