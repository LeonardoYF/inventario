<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetalleIngresoFormRequest extends FormRequest
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

            'id_producto' => 'required|max:10',
            'cantidad' => 'required',
            'precio_compra' => 'required',
            'precio_venta' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'id_producto.required' => 'El campo producto es requerido.',
            'id_producto.max' => 'El campo producto no debe exceder los 10 caracteres.',
            'cantidad.required' => 'El campo cantidad es requerido.',
            'precio_compra.required' => 'El campo precio de compra es requerido.',
            'precio_venta.required' => 'El campo precio de venta es requerido.',
        ];
    }
}
