<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtCookieAuth
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Leer token desde cookie
            $token = $request->cookie('access_token');

            if (!$token) {
                return response()->json(['error' => 'Token no encontrado'], 401);
            }

            // Validar token y autenticar usuario
            JWTAuth::setToken($token)->authenticate();

        } catch (\Exception $e) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        return $next($request);
    }
}
