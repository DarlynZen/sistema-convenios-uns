<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ConvenioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isCreate = $this->isMethod('post');

        return [
            'tipo_convenio_id' => 'required|exists:tipos_convenio,id',
            'ambito_id' => 'required|exists:ambitos,id',
            'estado_convenio_id' => 'required|exists:estados_convenio,id',
            'resolucion' => 'nullable|string|max:255',
            'titulo' => 'required|string|max:500',
            'objetivo_personalizado' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'duracion_valor' => 'required|integer|min:1',
            'duracion_unidad' => 'required|in:dias,semanas,meses,anios',
            'plazo_prorroga_valor' => 'required|integer|min:1',
            'plazo_prorroga_unidad' => 'required|in:dias,semanas,meses',
            'entidad_nombre' => 'required|string|max:255',
            'entidad_logo' => 'nullable|string|max:500',
            'entidad_tipo' => 'nullable|string|max:100',
            'nacionalidad' => 'nullable|string|max:100',
            'beneficiarios' => 'nullable|array',
            'beneficiarios.*' => 'exists:beneficiarios,id',
            'observaciones_prorroga' => 'nullable|string|max:2000',
            'observacion' => 'nullable|string|max:2000',
            'coordinador_uns' => 'nullable|array',
            'coordinador_uns.*' => 'nullable|string|max:255',
            'coordinador_institucion' => 'nullable|array',
            'coordinador_institucion.*' => 'nullable|string|max:255',
            'no_se_menciona' => 'nullable|array',
            'no_se_menciona.*' => 'nullable|in:1',
            'archivo_uno' => [($isCreate ? 'required_without:transcripcion_resolucion' : 'nullable'), 'file', 'mimes:pdf', 'max:5120'],
            'transcripcion_resolucion' => [($isCreate ? 'required_without:archivo_uno' : 'nullable'), 'file', 'mimes:pdf', 'max:5120'],
            'archivo_dos' => [($isCreate ? 'required_without:anexo_convenio' : 'nullable'), 'file', 'mimes:pdf', 'max:5120'],
            'anexo_convenio' => [($isCreate ? 'required_without:archivo_dos' : 'nullable'), 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $coordinadorUns = collect($this->input('coordinador_uns', []))
                ->map(fn($value) => trim((string) $value))
                ->filter()
                ->values();

            $coordinadorInstitucion = collect($this->input('coordinador_institucion', []))
                ->map(fn($value) => trim((string) $value))
                ->filter()
                ->values();

            $sinMencion = collect($this->input('no_se_menciona', []))->isNotEmpty();

            if ($coordinadorUns->isEmpty() && $coordinadorInstitucion->isEmpty() && !$sinMencion) {
                $validator->errors()->add(
                    'coordinador_uns',
                    'Debes registrar al menos un coordinador o marcar "No se menciona".'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'archivo_uno.required_without' => 'Debes adjuntar el archivo 1 en PDF.',
            'transcripcion_resolucion.required_without' => 'Debes adjuntar el archivo 1 en PDF.',
            'archivo_dos.required_without' => 'Debes adjuntar el archivo 2 en PDF.',
            'anexo_convenio.required_without' => 'Debes adjuntar el archivo 2 en PDF.',
            '*.mimes' => 'El archivo debe estar en formato PDF.',
            '*.max' => 'El archivo no debe superar 5 MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'tipo_convenio_id' => 'tipo de convenio',
            'ambito_id' => 'ámbito',
            'estado_convenio_id' => 'estado del convenio',
            'duracion_valor' => 'duración',
            'duracion_unidad' => 'unidad de duración',
            'plazo_prorroga_valor' => 'plazo de prórroga',
            'plazo_prorroga_unidad' => 'unidad de prórroga',
            'archivo_uno' => 'archivo 1',
            'archivo_dos' => 'archivo 2',
            'transcripcion_resolucion' => 'archivo 1',
            'anexo_convenio' => 'archivo 2',
            'observaciones_prorroga' => 'observaciones de prórroga',
            'coordinador_uns' => 'coordinador UNS',
            'coordinador_institucion' => 'coordinador institución',
        ];
    }
}

