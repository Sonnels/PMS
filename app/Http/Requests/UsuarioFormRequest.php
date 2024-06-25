<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioFormRequest extends FormRequest
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
            'Nombre'=>'max:100|required',
            'NumDocumento'=>'required|max:15',
            'password'=> !empty($this->password ) ? ['required', 'string', 'min:4', 'confirmed'] : [''],
            'email'=>'required|max:45|email|unique:usuario,email,' .  $this->IdUsuario . ',IdUsuario',
            'Celular'=>'max:11',

        ];
    }
    public function messages()
    {
        return [
            'NumDocumento.max' => 'El N° de Documento no debe contener más de 15 caracteres.',
            'password.required' => 'Debe ingresar una contraseña.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe contener al menos 4 caracteres.',
            'Celular.max' => 'El celular no debe contener más de 11 caracteres.',
            'email.required' => 'Debe ingresar un Correo electrónico.',
            'email.unique' => 'El valor del Correo Electrónico ya está en uso.'
        ];
    }
}
