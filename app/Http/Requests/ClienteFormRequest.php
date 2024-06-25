<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteFormRequest extends FormRequest
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
            'Nombre' => 'required|max:80|min:4',
            'Celular' => 'max:15',
            'Correo' => 'max:40',
            'TipDocumento' => 'required | max:40',
            // 'NumDocumento' => !empty($this->NumDocumento) ? 'numeric' : '',
            'NumDocumento'=>'required|unique:cliente,NumDocumento,'. $this->IdCliente .',IdCliente',
            'Direccion' => 'max:40',
            'nroMatricula' => 'max:50',
            'fecCli'=> 'date_format:Y-m-d'
        ];
    }
    public function messages()
    {
        return [
            'Nombre.required' => 'Ingrese los(el) Nombre(s) del Cliente.',
            'Nombre.max' => 'El tamaño del nombre del Cliente no debe se mayor a 80 caracteres.',
            'Apellido.required' => 'Ingrese los Apellidos del Cliente.',
            'Apellido.max' => 'El tamaño del texto no debe se mayor a 40 caracteres',
            'Correo.max' => 'El correo ingresado no debe se mayor a 45 caracteres',
            'TipDocumento.required' => 'el TipDocumento de habitacion es un campo requerido',
            'TipDocumento.max' => 'El tamaño del texto no debe se mayor a 40 caracteres',
            'NumDocumento.required' => 'Debe ingresar el Nro de Documento del Cliente.',
            'NumDocumento.numeric' => 'El Nro de Documento debe ser un valor numérico.',
            'Direccion.required' => 'el Direccion de habitacion es un campo requerido',
            'Direccion.max' => 'El tamaño del texto no debe se mayor a 40 caracteres.',
            'Celular.required' => 'Debe ingresar el número de Celular del Cliente.',
            'Celular.numeric' => 'El Celular debe ser un valor numérico.',
            'nroMatricula.max' => 'El valor del N° de matrícula no debe se mayor a 50 caracteres.',
            'NumDocumento.unique' => 'El valor del N° documento ya está en uso.',
            'fecCli.date_format' => 'El campo fecha nacimiento no es un valor valido.'
        ];
    }
}
