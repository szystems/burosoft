<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CuentaFormRequest extends FormRequest
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
            'nit' => 'required',
            'dpi' => 'nullable|string|max:15',
            'razon_social' => 'required',
            'telefono' => 'nullable|string|max:10',
            'correo' => 'nullable|email',
            'direccion' => 'nullable',
            'otra_forma_contacto' => 'nullable',
            'datos_intermediario_nombre' => 'nullable',
            'datos_intermediario_telefono' => 'nullable|string|max:10',
            'datos_intermediario_correo' => 'nullable|email',
            'datos_propietario_nombre' => 'nullable',
            'datos_propietario_telefono' => 'nullable|string|max:10',
            'datos_propietario_correo' => 'nullable|email'
        ];
    }
}
