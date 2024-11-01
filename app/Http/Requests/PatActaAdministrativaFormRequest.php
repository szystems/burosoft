<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatActaAdministrativaFormRequest extends FormRequest
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
            'fecha' => 'required|date',
            'quienes_intervinieron' => 'nullable|string',
            'tipo_acta' => 'required|in:Limpia,Con Acuerdo,De Inconformidad,Otro',
            'tipo_acta_otro' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'archivo' => 'nullable|max:3000',
            'tipo' => 'nullable|string|max:50',
            'usuario_id' => 'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'pat_id.required' => 'El campo pat_id es obligatorio',
            'pat_id.exists' => 'El pat_id no existe',
            'fecha.required' => 'El campo fecha es obligatorio',
            'fecha.date' => 'El campo fecha debe ser una fecha válida',
            'tipo_acta.required' => 'El campo tipo_acta es obligatorio',
            'tipo_acta.in' => 'El campo tipo_acta debe ser uno de los siguientes valores: Limpia, Con Acuerdo, De Inconformidad, Otro',
            'usuario_id.required' => 'El campo usuario_id es obligatorio',
            'usuario_id.exists' => 'El usuario_id no existe',
        ];
    }
}
