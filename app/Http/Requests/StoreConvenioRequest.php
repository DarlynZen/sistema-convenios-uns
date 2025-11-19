<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConvenioRequest extends FormRequest
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
            'tipo_convenio_id' => 'required|exists:tipos_convenio,id',
            'ambito_id' => 'required|exists:ambitos,id',
            'estado_convenio_id' => 'required|exists:estados_convenio,id',
            'resolucion' => 'nullable|string|max:255',
            'titulo' => 'required|string|max:500',
            'objetivo_personalizado' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'plazo_prorroga_valor' => 'nullable|integer',
            'plazo_prorroga_unidad' => 'nullable|string|max:50',
            'entidad_nombre' => 'required|string|max:255',
            'entidad_logo' => 'nullable|string|max:500',
            'entidad_tipo' => 'nullable|string|max:100',
            'nacionalidad' => 'nullable|string|max:100',
            'beneficiarios' => 'nullable|array',
            'beneficiarios.*' => 'exists:beneficiarios,id',
        ];
    }
}

