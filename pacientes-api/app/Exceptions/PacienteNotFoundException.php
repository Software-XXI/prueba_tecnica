<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PacienteNotFoundException extends Exception
{
    protected $statusCode = 404;

    public function __construct($id = null, $message = null)
    {
        $this->message = $message ?? "Paciente con ID {$id} no encontrado";
        parent::__construct($this->message);
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'status' => $this->statusCode,
            'message' => $this->message,
        ], $this->statusCode);
    }
}
