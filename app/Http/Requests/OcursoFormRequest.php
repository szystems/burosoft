<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OcursoFormRequest extends FormRequest
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
            'fecha_hora_presentacion' => 'required|date',
            'numero_documento'        => 'required|string',
            'oficina_agencia_ea'      => 'nullable|string|max:300',
            'usuario_id'              => 'required|integer',
            'audiencia_id'            => 'required|integer',
            'observaciones'           => 'nullable|string',
            'numero_folios'           => 'nullable|integer|min:1',
        ];
    }
}
