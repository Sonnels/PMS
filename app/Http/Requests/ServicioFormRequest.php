<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicioFormRequest extends FormRequest
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
            'NombProducto'=>'max:191|required',
            'Precio'=>'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'NombProducto.required' => 'El campo nombre es obligatorio.',
            'NombProducto.max' => 'El campo nombre no debe contener más de 191 caracteres.',
            'Precio.numeric' => 'El campo precio debe ser un número.',
            'Precio.required' => 'El campo precio es obligatorio.'
        ];
    }
}
