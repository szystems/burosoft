<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatNulidadFormRequest extends FormRequest
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
            'no' => 'required|string',
            'fecha' => 'date',
            'tipo_nulidad' => 'required|string',
            'nueva_notificacion' => 'required|string',
            'usuario_id' => 'required|string',
        ];
    }
}
