<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorFormRequest extends FormRequest
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
             // Cambiar ']' por ','
            'nombre' => 'required|max:100',
            'tipo_documento' => 'max:50',
            'numero_documento' => 'max:50',
            'direccion' => 'max:250',
            'telefono' => 'max:10',
            'email' => 'max:50',
        ];
    }
    public function messages(): array
    {
        return [
            
            'tipo_persona.max' => 'El campo tipo de persona no debe exceder los 50 caracteres.',
            'nombre.required' => 'El campo nombre es requerido.',
            'nombre.max' => 'El campo nombre no debe exceder los 100 caracteres.',
            'tipo_documento.max' => 'El campo tipo de documento no debe exceder los 50 caracteres.',
            'numero_documento.max' => 'El campo número de documento no debe exceder los 50 caracteres.',
            'direccion.max' => 'El campo dirección no debe exceder los 250 caracteres.',
            'telefono.max' => 'El campo teléfono no debe exceder los 10 caracteres.',
            'email.max' => 'El campo email no debe exceder los 50 caracteres.',
        ];
    }
}
