<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Pago2Request extends FormRequest
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
            'metPag' => 'required|max:45',
            'monPag' => 'required|numeric',
            // 'IdReserva' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'motPag.max' => 'El método de pago no debe contener más de 45 caracteres.',
            'monPag.required' => 'El monto del pago es obligario.',
            'monPag.numeric' => 'El monto del pago debe ser un número.'
            // 'IdReserva.required' => 'Tiene que seleccionar una habitación.'
        ];
    }
}
