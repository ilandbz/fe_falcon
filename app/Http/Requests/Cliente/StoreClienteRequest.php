<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
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
            'dni'               => 'required|max:25|digits:8',
            'ape_pat'           => 'required',
            'ape_mat'           => 'required',
            'primernombre'      => 'required',
            'otrosnombres'      => 'required',
            'ubigeo'            => 'digits:6',
            'celular'           => 'required|digits:9',
            'ubigeodomicilio'   => 'digits:6',
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Dato Obligatorio',
            'max' => 'Ingrese Máximo :max caracteres',
            'string' => 'Ingrese caracteres alfanuméricos',
            'dni.digits' => 'Solo 8 digitos numericos',
            'celular.digits' => 'Solo 9 digitos',
            'ubigeo.digits' => 'Solo 6 digitos',
            'ubigeodomicilio.digits' => 'Solo 6 digitos',
            'number' => 'Ingrese solo numeros',
            'unique' => 'El valor ya existe'
        ];
    }

}