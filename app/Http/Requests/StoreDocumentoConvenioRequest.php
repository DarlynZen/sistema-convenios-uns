<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\TipoDocumentoConvenio;

class DocumentoConvenioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        $isStore = $this->isMethod('post');

        return [
            'tipo_documento' => ['required','string', Rule::in(TipoDocumentoConvenio::values())],
            'nombre_documento' => 'required|string|max:255',
            'documento' => [$isStore ? 'required' : 'nullable', 'file', 'mimes:pdf', 'max:10240'],
            'version' => 'nullable|integer|min:1',
            'activo' => 'nullable|boolean',
            'observaciones' => 'nullable|string',
        ];
    }
}
