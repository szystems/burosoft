<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConstanciaPagoFormRequest extends FormRequest
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
            'usuario_id' => 'required|exists:users,id',
            'fecha_pago' => 'required|date',
            'identificacion' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'tipo_archivo' => 'nullable|string|max:10'
        ];
    }

    public function messages()
    {
        return [
            'pat_id.required' => 'El PAT es requerido.',
            'pat_id.exists' => 'El PAT seleccionado no existe.',
            'usuario_id.required' => 'El usuario es requerido.',
            'usuario_id.exists' => 'El usuario seleccionado no existe.',
            'fecha_pago.required' => 'La fecha de pago es requerida.',
            'fecha_pago.date' => 'La fecha de pago debe ser una fecha válida.',
            'identificacion.required' => 'La identificación es requerida.',
            'identificacion.string' => 'La identificación debe ser texto.',
            'identificacion.max' => 'La identificación no puede exceder 255 caracteres.',
            'descripcion.required' => 'La descripción es requerida.',
            'descripcion.string' => 'La descripción debe ser texto.',
            'archivo.file' => 'El archivo debe ser un archivo válido.',
            'archivo.mimes' => 'El archivo debe ser de tipo: pdf, doc, docx, jpg, jpeg, png.',
            'archivo.max' => 'El archivo no puede ser mayor a 10MB.',
            'tipo_archivo.string' => 'El tipo de archivo debe ser texto.',
            'tipo_archivo.max' => 'El tipo de archivo no puede exceder 10 caracteres.'
        ];
    }
}
