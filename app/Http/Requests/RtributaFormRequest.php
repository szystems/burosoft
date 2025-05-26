<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RtributaFormRequest extends FormRequest
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
            'fecha' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'tipo_resolucion' => 'required|in:total a favor,total en contra,parcial,nulidad,penal',
            'usuario_id' => 'required|exists:users,id',
            'audiencia_id' => 'required|exists:audiencias,id',
            'observaciones' => 'nullable|string',
        ];
    }
}
