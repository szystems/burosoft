<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovimientoFormRequest extends FormRequest
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
            'usuario_id' => 'required|exists:users,id',
            'empresa_id' => 'required|exists:empresas,id',
            'cuenta_id' => 'required|exists:cuentas,id',
            'rubro_id' => 'required|exists:rubros,id',
            'monto_q' => 'required|numeric',
            'monto_d' => 'required|numeric',
            'descripcion' => 'required|string',
        ];
    }
}
