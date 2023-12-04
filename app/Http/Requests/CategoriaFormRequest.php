<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'categoria' => 'required|max:50',
            'descripcion' => 'max:256',
        ];
    }
    public function messages(): array
    {
        return [
            'categoria.required' => 'El campo categoría es requerido.',
            'categoria.max' => 'El campo categoría no debe exceder los 50 caracteres.',
            'descripcion.max' => 'El campo descripción no debe exceder los 256 caracteres.',
        ];
    }
}
