<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RtributaFormRequest extends FormRequest
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
            'fecha_hora_notificacion' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'tipo_resolucion' => 'required|in:total a favor,total en contra,parcial,nulidad,penal,otro',
            'tipo_resolucion_otro' => 'required_if:tipo_resolucion,otro|nullable|string|max:255',
            'fecha_resolucion' => 'nullable|date',
            'plazo_cat' => 'nullable|in:5 días,10 días,15 días,30 días,45 días,60 días,3 meses,otro',
            'plazo_cat_otro' => 'required_if:plazo_cat,otro|nullable|string|max:255',
            'usuario_id' => 'required|exists:users,id',
            'audiencia_id' => 'required|exists:audiencias,id',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ];
    }
}
