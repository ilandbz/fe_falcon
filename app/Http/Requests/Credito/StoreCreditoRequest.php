<?php

namespace App\Http\Requests\Credito;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreditoRequest extends FormRequest
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
            'cliente_id'    => 'required|exists:clientes,id',
            'agencia_id'    => 'required|exists:agencias,id',
            'asesor_id'     => 'required|exists:users,id',
            'estado'        => 'required|string|max:40',
            'fecha_reg'     => 'required|date',
            'tipo'          => 'required|string|max:40',
            'monto'         => 'required|numeric|between:0,999999999.99',
            'producto'      => 'required|string|max:30',
            'frecuencia'    => 'required|string|max:30',
            'plazo'         => 'required|integer|min:1|max:99999',
            'medioorigen'   => 'required|string|max:50',
            'dondepagara'   => 'nullable|string|max:40',
            'fuenterecursos'=> 'required|string|max:50',
            'tasainteres'   => 'nullable|numeric|between:0,99.99',
            'total'         => 'nullable|numeric|between:0,999999999.99',
            'costomora'     => 'nullable|numeric|between:0,99.99',
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