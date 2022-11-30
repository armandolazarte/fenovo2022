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
            'cuit' => 'required|unique:proveedors,cuit,' . $this->proveedor_id,
            'name' => 'required',
        ];
    }
}
