<?php

namespace App\Http\Requests\Proveedors;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'cuit' => 'required|string|min:11|max:11|cuil|unique:proveedors',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Razon social es requerida',
            'cuit.required' => 'El cuit es requerido!',
            'cuil.cuil'     => 'El nro de cuit no es válido !',
        ];
    }
}
