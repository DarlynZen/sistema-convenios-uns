<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentoConvenioRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'tipo_documento' => 'required|string|max:100',
            'nombre_documento' => 'required|string|max:255',
            'documento' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'version' => 'nullable|integer|min:1',
            'activo' => 'nullable|boolean',
            'observaciones' => 'nullable|string',
        ];
    }
}

