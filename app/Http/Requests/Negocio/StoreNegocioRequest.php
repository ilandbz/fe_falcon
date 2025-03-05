<?php

namespace App\Http\Requests\Negocio;

use Illuminate\Foundation\Http\FormRequest;

class StoreNegocioRequest extends FormRequest
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
            'cliente_id' => 'required|integer|exists:clientes,id',
            'razonsocial' => 'required|string|max:80',
            'ruc' => 'required|string|size:11|unique:tabla_nombre,ruc',
            'tel_cel' => 'nullable|string|size:11',
            'tipo_actividad_id' => 'required|integer|exists:tipo_actividades,id',
            'descripcion' => 'nullable|string|max:90',
            'inicioactividad' => 'required|date',
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