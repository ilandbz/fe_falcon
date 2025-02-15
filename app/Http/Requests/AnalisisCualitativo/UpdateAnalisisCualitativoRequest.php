<?php

namespace App\Http\Requests\AnalisisCualitativo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnalisisCualitativoRequest extends FormRequest
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
            'tipogarantia' => 'required|integer|in:2,4',
            'cargafamiliar' => 'required|integer|in:0,1,2,4',
            'riesgoedadmax' => 'required|integer|in:1,3',
            'antecedentescred' => 'required|integer|in:1,3,4,5',
            'recorpagoult' => 'required|integer|in:0,2,5,7',
            'niveldesarr' => 'required|integer|in:1,2,3,4',
            'tiempo_neg' => 'required|integer|in:1,2,3',
            'control_integre' => 'required|integer|in:1,2,3',
            'vent_totdec' => 'required|integer|in:0,2',
            'compsubsector' => 'required|integer|in:0,2,4',
            'totunidfamiliar' => 'required|integer|min:0',
            'totunidempresa' => 'required|integer|min:0',
            'total' => 'required|integer|min:0',
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