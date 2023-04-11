<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class NuevoProductoRequest extends FormRequest
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
            "producto"=> array(
                "required", "string"
            ),
            "descripcion"=> array(
                "required", "string"
            ),
            "precio_unitario"=> array(
                "required", "numeric", "min:0.01"
            ),
            "categorias_id"=> array(
                "required", "integer"
            ),
        ];
    }
    public function messages()
    {
        return array(
            "producto.required" => "El nombre del producto es requerido",
            "precio_unitario.required" => "El precio del producto es requerido",
            "precio_unitario.numeric" => "El precio del producto debe ser un numero",
            "precio_unitario.min" => "El precio del producto debe ser mayor que 0",
            "descripcion.required" => "La descripcion del producto es requerida",
            "categorias_id.required" => "La categoria del producto es requerida"
        );
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $formato = array(
            "error"=> "Algunos datos han fallado",
            "detalles"=>$errors
        );
        $respuesta = response()->json($formato,422);
        throw new ValidationException($validator, $respuesta);

    }

}
