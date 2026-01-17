<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$accessToken = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        $refreshToken = JWTAuth::claims([
            'exp' => now()->addDays(7)->timestamp
        ])->fromUser(JWTAuth::user());

        // Cookies seguras, HTTP Only, SameSite=Lax
        $accessCookie = cookie(
            'access_token',
            $accessToken,
            config('jwt.ttl'), // minutos, viene del fichero config/jwt.php
            null,
            null,
            true,   // secure (solo HTTPS)
            true,   // httpOnly
            false,  // raw
            'Lax'   // SameSite
        );
        $refreshCookie = cookie(
            'refresh_token',
            $refreshToken,
            60 * 24 * 7, // 7 días
            null,
            null,
            true,
            true,
            false,
            'Lax'
        );

        return response()->json([
            'message' => 'Login correcto'
        ])->withCookie($accessCookie)
          ->withCookie($refreshCookie);
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->input('refresh_token');
        try {
            $newAccessToken = JWTAuth::setToken($refreshToken)->refresh();

            $accessCookie = cookie(
                'access_token',
                $newAccessToken,
                config('jwt.ttl'),
                null,
                null,
                true,
                true,
                false,
                'Lax'
            );

            return response()->json(['message' => 'Token refrescado'])->withCookie($accessCookie);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Refresh token inválido'], 401);
        }
    }
}