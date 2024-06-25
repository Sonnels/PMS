<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApartarFormRequest extends FormRequest
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
            // 'FechReserva' => 'required|date_format:Y-m-d H:i:s',
            // 'FechEntrada' => 'date_format:d-m-Y H:i:s',
            'FechSalida' => 'after_or_equal:FechReserva',
            'IdCliente' => 'required',
            'Num_Hab' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'IdCliente.required' => 'Debe seleccionar un Cliente.',
        ];
    }
}
