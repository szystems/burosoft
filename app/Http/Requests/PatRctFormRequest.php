<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatRctFormRequest extends FormRequest
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
        $rules = [
            'fecha_citacion' => 'required|date',
            'medio_citacion' => 'required|string',
            'medio_citacion_otro' => 'nullable|string',
            'fecha_atencion' => 'required|date',
            'participantes_reunion' => 'required|string',
            'lugar_celebracion' => 'required|string',
            'descripcion_resultado' => 'required|string',
            'suscribe_acta' => 'required|string|in:Si,No',
            'archivo_acta' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'archivo_recibo_pago' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ];

        // Solo requerir pat_id para creación (POST), no para actualización (PUT)
        if ($this->isMethod('post')) {
            $rules['pat_id'] = 'required|integer';
        }

        return $rules;
    }
}
