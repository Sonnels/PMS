<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ReservaFormRequest extends FormRequest
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
            'CostoAlojamiento' => 'numeric',
            'Observacion' => 'max:200',
            'Estado' => 'required',
            'IdCliente' => 'required',
            'Num_Hab' => 'required',
            'Adelanto'=> 'numeric|min:0',
            'Descuento' => !empty($this->Descuento) ? 'numeric|max:'. $this->CostoAlojamiento . '|min:0' : '',
            // 'IdUsuario' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'Num_Hab.required' => 'Debe seleccionar una Habitación.',
            'Adelanto.max' => 'El Adelanto no debe ser mayor a ' . $this->pagar . '.',
            'Descuento.max' => 'El Descuento no debe ser mayor a ' . $this->CostoAlojamiento . '.',
            'Adelanto.min' => 'El Adelanto no debe ser un valor negativo.',
            'Descuento.min' => 'El Descuento no debe ser un valor negativo.',
        ];
    }

}
