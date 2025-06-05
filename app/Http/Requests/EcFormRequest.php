<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EcFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {        return [
            'audiencia_id' => 'required|exists:audiencias,id',
            'numero_resolucion' => 'required|string|max:1000',
            'observaciones' => 'nullable|string|max:5000',
            'usuario_id' => 'required|exists:users,id',
            'numero_folios' => 'nullable|integer|min:1'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'audiencia_id.required' => 'La audiencia es requerida.',
            'audiencia_id.exists' => 'La audiencia seleccionada no existe.',
            'numero_resolucion.required' => 'El número de resolución es requerido.',
            'numero_resolucion.string' => 'El número de resolución debe ser texto.',
            'numero_resolucion.max' => 'El número de resolución no puede exceder los 1000 caracteres.',
            'observaciones.string' => 'Las observaciones deben ser texto.',
            'observaciones.max' => 'Las observaciones no pueden exceder los 5000 caracteres.',
            'usuario_id.required' => 'El usuario es requerido.',
            'usuario_id.exists' => 'El usuario seleccionado no existe.'
        ];
    }
}
