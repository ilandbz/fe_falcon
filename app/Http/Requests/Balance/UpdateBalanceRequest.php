<?php

namespace App\Http\Requests\Balance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBalanceRequest extends FormRequest
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
            'credito_id' => 'required|integer|exists:creditos,id',
            'total_activo' => 'required|numeric|min:0',
            'total_pasivo' => 'required|numeric|min:0',
            'patrimonio' => 'required|numeric|min:0',
            'fecha' => 'required|numeric|min:0',
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