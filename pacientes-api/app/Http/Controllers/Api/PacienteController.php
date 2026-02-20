<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Paciente::query();

        if ($request->has('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nombre1', 'like', "%$q%")
                    ->orWhere('apellido1', 'like', "%$q%")
                    ->orWhere('correo', 'like', "%$q%");
            });
        }

        return $query->orderBy('id', 'desc')->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'numero_documento' => 'required|string',
            'nombre1' => 'required|string',
            'nombre2' => 'nullable|string',
            'apellido1' => 'required|string',
            'apellido2' => 'nullable|string',
            'genero_id' => 'required|exists:generos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'municipio_id' => 'required|exists:municipios,id',
            'correo' => 'required|email|unique:pacientes,correo',
        ]);

        $paciente = Paciente::create($data);

        return response()->json([
            'message' => 'Paciente creado correctamente',
            'data' => $paciente
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        return response()->json($paciente, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $paciente = Paciente::findOrFail($id);

        $data = $request->validate([
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'numero_documento' => 'required|string',
            'nombre1' => 'required|string',
            'nombre2' => 'nullable|string',
            'apellido1' => 'required|string',
            'apellido2' => 'nullable|string',
            'genero_id' => 'required|exists:generos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'municipio_id' => 'required|exists:municipios,id',
            'correo' => 'required|email|unique:pacientes,correo,' . $paciente->id,
        ]);

        $paciente->update($data);

        return response()->json([
            'message' => 'Paciente actualizado correctamente',
            'data' => $paciente
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();

        return response()->json([
            'message' => 'Paciente eliminado correctamente'
        ]);
    }
}