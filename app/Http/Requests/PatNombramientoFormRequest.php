<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatNombramientoFormRequest extends FormRequest
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
            'nombrado_1' => 'required',
            'periodo' => 'required',
            'usuario_id' => 'required|integer',
        ];
    }
}
