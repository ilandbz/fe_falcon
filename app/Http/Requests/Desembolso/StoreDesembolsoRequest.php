<?php

namespace App\Http\Requests\Desembolso;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDesembolsoRequest extends FormRequest
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
            'credito_id'     => 'required|exists:creditos,id',
            'fecha'          => 'required|date',
            'hora'           => 'required|date_format:H:i:s',
            'user_id'        => 'required|exists:users,id',
            'descontado'     => 'required|numeric|min:0',
            'totalentregado' => 'required|numeric|min:0',
            'rcsdebe'        => ['required', Rule::in(['pago'])],
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Dato Obligatorio',
            'max' => 'Ingrese Máximo :max caracteres',
            'string' => 'Ingrese caracteres alfanuméricos',
            'number' => 'Ingrese solo numeros',
            'unique' => 'El valor ya existe',
            'rcsdebe.in' => 'Aun debe creditos',
        ];
    }

}