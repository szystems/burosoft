<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovimientoPagoFormRequest extends FormRequest
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
            'movimiento_id' => 'required|integer',
            'descripcion' => 'required',
            'forma_pago' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png|max:3048',
            'usuario_id' => 'required|exists:users,id',
            'monto_q' => 'required|numeric',
            'monto_d' => 'required|numeric'
        ];
    }
}
