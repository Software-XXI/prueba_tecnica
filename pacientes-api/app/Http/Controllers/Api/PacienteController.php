<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource with search and pagination.
     */
    public function index(Request $request)
    {
        $query = Paciente::query();

        // Búsqueda opcional
        if ($request->has('q') && !empty($request->q)) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nombre1', 'like', "%{$q}%")
                    ->orWhere('apellido1', 'like', "%{$q}%")
                    ->orWhere('correo', 'like', "%{$q}%");
            });
        }

        return $query->orderBy('id', 'desc')->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     * Utiliza Form Request para validación centralizada.
     */
    public function store(StorePacienteRequest $request)
    {
        $paciente = Paciente::create($request->validated());

        return response()->json([
            'message' => 'Paciente creado correctamente',
            'data' => $paciente
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paciente $paciente)
    {
        return response()->json($paciente, 200);
    }

    /**
     * Update the specified resource in storage.
     * Utiliza Form Request para validación centralizada.
     */
    public function update(UpdatePacienteRequest $request, Paciente $paciente)
    {
        $paciente->update($request->validated());

        return response()->json([
            'message' => 'Paciente actualizado correctamente',
            'data' => $paciente
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();

        return response()->json([
            'message' => 'Paciente eliminado correctamente'
        ], 200);
    }
}