<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Login user and return access token.
     * Utiliza Form Request para validación centralizada.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    /**
     * Get authenticated user info.
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Logout user.
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Sesión cerrada']);
    }
}