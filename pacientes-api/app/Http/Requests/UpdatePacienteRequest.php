<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePacienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $pacienteId = $this->route('paciente');

        return [
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'numero_documento' => 'required|string|unique:pacientes,numero_documento,' . $pacienteId,
            'nombre1' => 'required|string|min:2|max:50',
            'nombre2' => 'nullable|string|max:50',
            'apellido1' => 'required|string|min:2|max:50',
            'apellido2' => 'nullable|string|max:50',
            'genero_id' => 'required|exists:generos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'municipio_id' => 'required|exists:municipios,id',
            'correo' => 'required|email|unique:pacientes,correo,' . $pacienteId,
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'numero_documento.unique' => 'Este número de documento ya está registrado',
            'correo.unique' => 'Este correo ya está registrado',
            'nombre1.min' => 'El nombre debe tener al menos 2 caracteres',
            'apellido1.min' => 'El apellido debe tener al menos 2 caracteres',
            'correo.email' => 'El correo debe ser un email válido',
        ];
    }
}
