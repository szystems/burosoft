<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NulidadFormRequest extends FormRequest
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
    {        $rules = [
            'audiencia_id' => 'required|exists:audiencias,id',
            'usuario_id' => 'required|exists:users,id',
            'fecha' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
            'tipo_nulidad' => 'required|in:Absoluta,Relativa',
            'numero_folios' => 'nullable|integer|min:1',
        ];

        // Si es un POST (crear), el archivo es requerido
        if ($this->isMethod('post')) {
            $rules['archivo'] = 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240';
        } else {
            // Si es un PUT (actualizar), el archivo es opcional
            $rules['archivo'] = 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240';
        }

        return $rules;
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
            'usuario_id.required' => 'El usuario es requerido.',
            'usuario_id.exists' => 'El usuario seleccionado no existe.',
            'fecha.required' => 'La fecha de notificación es requerida.',
            'fecha.date' => 'La fecha debe ser una fecha válida.',
            'numero_resolucion.required' => 'El número de resolución es requerido.',
            'numero_resolucion.string' => 'El número de resolución debe ser un texto.',
            'numero_resolucion.max' => 'El número de resolución no puede exceder 255 caracteres.',
            'archivo.required' => 'El archivo es requerido.',
            'archivo.file' => 'Debe seleccionar un archivo válido.',
            'archivo.mimes' => 'El archivo debe ser de tipo: pdf, doc, docx, jpg, jpeg, png.',
            'archivo.max' => 'El archivo no puede exceder 10MB.',
            'observaciones.string' => 'Las observaciones deben ser texto.',
            'tipo_nulidad.required' => 'El tipo de nulidad es requerido.',
            'tipo_nulidad.in' => 'El tipo de nulidad debe ser Absoluta o Relativa.',
        ];
    }
}
