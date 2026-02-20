<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UnauthorizedException extends Exception
{
    protected $statusCode = 403;

    public function __construct($message = 'No autorizado para realizar esta acción')
    {
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
