<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MpmrPaFormRequest extends FormRequest
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
            'fecha_hora' => 'required|date_format:Y-m-d\TH:i',
            'fecha_resolucion' => 'nullable|date',
            'numero_resolucion' => 'required|string|max:255',
            'audiencia_pa_id' => 'required|exists:audiencias_pa,id',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ];
    }
}
