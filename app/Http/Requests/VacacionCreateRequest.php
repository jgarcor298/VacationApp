<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacacionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all authenticated users (controlled by middleware later)
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'idtipo' => 'required|exists:tipo,id',
            'pais' => 'required|string|max:100',
            'foto' => 'nullable|image|max:2048', // Allow one photo for simplicity in create
        ];
    }
    
    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'idtipo.exists' => 'El tipo de vacación seleccionado no es válido.',
            'foto.image' => 'El archivo debe ser una imagen.',
        ];
    }
}
