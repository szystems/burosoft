<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatFormRequest extends FormRequest
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
            'cuenta_id' => 'required|integer',
            'usuario_id' => 'required|integer',
            'no_expediente' => 'required|string',
            'no_programa' => 'required|string',
            'gerencia' => 'required|string',
            'tipo_contribuyente' => 'required|string',
            'estado' => 'required|string',
        ];
    }
}
