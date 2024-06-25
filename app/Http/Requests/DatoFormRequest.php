<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatoFormRequest extends FormRequest
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
            'Nombre'=>'max:50|required',
            'Direccion'=>'max:50|required',
            'ruc'=>'max:15',
            'Telefono'=>'max:20',
            'simboloMoneda'=>'max:3'
        ];
    }
}
