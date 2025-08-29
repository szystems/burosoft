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
            'fecha_hora_notificacion' => 'nullable|date',
            'fecha_resolucion' => 'nullable|date',
            'juzgado_que_conoce' => 'nullable|string|max:500',
            'medidas_decretadas' => 'nullable|array',
            'medidas_decretadas.*' => 'nullable|string|in:Arraigo,Bloqueo de cuentas,Bloqueo de Vehiculos,Bloqueo de bienes inmuebles,Interventor,Otro',
            'medidas_decretadas_otro' => 'nullable|string|max:500',
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
            'fecha_hora_notificacion.date' => 'La fecha y hora de notificación debe ser una fecha válida.',
            'fecha_resolucion.date' => 'La fecha de resolución debe ser una fecha válida.',
            'juzgado_que_conoce.string' => 'El juzgado que conoce debe ser texto.',
            'juzgado_que_conoce.max' => 'El juzgado que conoce no puede exceder los 500 caracteres.',
            'medidas_decretadas.array' => 'Las medidas decretadas deben ser un arreglo.',
            'medidas_decretadas_otro.string' => 'La otra medida decretada debe ser texto.',
            'medidas_decretadas_otro.max' => 'La otra medida decretada no puede exceder los 500 caracteres.',
            'observaciones.string' => 'Las observaciones deben ser texto.',
            'observaciones.max' => 'Las observaciones no pueden exceder los 5000 caracteres.',
            'usuario_id.required' => 'El usuario es requerido.',
            'usuario_id.exists' => 'El usuario seleccionado no existe.'
        ];
    }
}
