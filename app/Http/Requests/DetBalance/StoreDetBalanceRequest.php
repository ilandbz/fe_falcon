<?php

namespace App\Http\Requests\DetBalance;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetBalanceRequest extends FormRequest
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
            
            'activocaja' => 'required|numeric|min:0',
            'activobancos' => 'required|numeric|min:0',
            'activotascobrar' => 'required|numeric|min:0',
            'activoinventarios' => 'required|numeric|min:0',
            'pasivodeudaprove' => 'required|numeric|min:0',
            'pasivodeudanet' => 'required|numeric|min:0',
            'pasivodeudaempre' => 'required|numeric|min:0',
            'activomueble' => 'required|numeric|min:0',
            'activootrosact' => 'required|numeric|min:0',
            'activodepre' => 'required|numeric|min:0',
            'pasivolargo' => 'required|numeric|min:0',
            'otrascuentasapagar' => 'required|numeric|min:0',
            'totalacorriente' => 'required|numeric|min:0',
            'totalpcorriente' => 'required|numeric|min:0',
            'totalpncorriente' => 'required|numeric|min:0',
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