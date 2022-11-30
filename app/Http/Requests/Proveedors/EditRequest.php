<?php

namespace App\Http\Requests\Proveedors;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'cuit' => 'required|unique:proveedors,cuit,' . $this->proveedor_id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Razon social es requerida',
            'cuit.required' => 'El cuit es requerido!'
        ];
    }
}
