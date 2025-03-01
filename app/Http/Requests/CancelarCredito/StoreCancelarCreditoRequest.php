<?php

namespace App\Http\Requests\CancelarCredito;

use Illuminate\Foundation\Http\FormRequest;

class StoreCancelarCreditoRequest extends FormRequest
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

            'credito_id' => 'required',
            'fecha' => 'required',
            'hora' => 'required',
            'montopagado' => 'required',
            'user_id' => 'required',
            'mediopago' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Dato Obligatorio',
            'max' => 'Ingrese Máximo :max caracteres',
            'string' => 'Ingrese caracteres alfanuméricos',
            'number' => 'Ingrese solo numeros',
            'unique' => 'El valor ya existe'
        ];
    }

}