<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitanteFormRequest extends FormRequest
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
            //
            'nomVis' => 'required|max:191',
            'nroDocVis'=>'required|max:15|unique:visitantes,nroDocVis,' .  $this->idVisitante . ',idVisitante',
            'telVis' => 'max:15',
            'dirVis' => 'max:15'
        ];
    }
    public function messages()
    {
        return [
            'nroDocVis.unique' => 'El valor del N° Documento ya está en uso.'
        ];

    }
}
