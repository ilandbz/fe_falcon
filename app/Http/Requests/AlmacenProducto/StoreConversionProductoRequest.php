<?php

namespace App\Http\Requests\AlmacenProducto;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlmacenProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules():array
    {
        return [
            'producto_id' => 'required',
            'almacen_id' => 'required',
            'cantidad'      => 'numeric'
        ];
    }

    public function messages():array
    {
        return [
            'required' => '* Dato Obligatorio',
            'unique' => 'El nombre ya existe',
            'numeric'   => 'Tiene que ser valor numerico'
        ];
    }
}