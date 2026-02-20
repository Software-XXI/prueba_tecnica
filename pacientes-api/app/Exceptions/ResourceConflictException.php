<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ResourceConflictException extends Exception
{
    protected $statusCode = 409;

    public function __construct($resource = 'Recurso', $field = null)
    {
        $message = $field 
            ? "{$resource} con este {$field} ya existe"
            : "{$resource} ya existe";
        
        $this->message = $message;
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
