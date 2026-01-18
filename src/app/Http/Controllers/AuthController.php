<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use OpenApi\Attributes as OA;

#[OA\PathItem(path: "/api")]
class AuthController extends Controller
{
    // -------------------------
    // LOGIN
    // -------------------------

    #[OA\Post(
        path: "/api/login",
        summary: "Iniciar sesión",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(
                        property: "email",
                        type: "string",
                        example: "test@example.com"
                    ),
                    new OA\Property(
                        property: "password",
                        type: "string",
                        example: "123456"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Login correcto",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Login correcto"
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Credenciales inválidas",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "error",
                            type: "string",
                            example: "Credenciales inválidas"
                        )
                    ]
                )
            )
        ]
    )]
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

    // -------------------------
    // REFRESH TOKEN
    // -------------------------

    #[OA\Post(
        path: "/api/refresh",
        summary: "Refrescar token de acceso",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["refresh_token"],
                properties: [
                    new OA\Property(
                        property: "refresh_token",
                        type: "string",
                        example: "eyJhbGciOiJIUzI1..."
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Token refrescado",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Token refrescado"
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Refresh token inválido",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "error",
                            type: "string",
                            example: "Refresh token inválido"
                        )
                    ]
                )
            )
        ]
    )]
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

    // documentacion de logout
    #[OA\Post(
    path: "/api/logout",
    summary: "Cerrar sesión",
    tags: ["Auth"],
    responses: [
        new OA\Response(
            response: 200,
            description: "Logout correcto",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "message",
                        type: "string",
                        example: "Logout correcto"
                    )
                ]
            )
        ),
        new OA\Response(
            response: 400,
            description: "No se pudo cerrar sesión",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "error",
                        type: "string",
                        example: "No se pudo cerrar sesión"
                    )
                ]
            )
        )
    ]
)]
    public function logout(Request $request)
{
    try {
        // 1. Invalidar access token si existe
        if ($request->cookie('access_token')) {
            JWTAuth::setToken($request->cookie('access_token'))->invalidate();
        }

        // 2. Invalidar refresh token si existe
        if ($request->cookie('refresh_token')) {
            JWTAuth::setToken($request->cookie('refresh_token'))->invalidate();
        }

        // 3. Borrar cookies
        $clearAccess = cookie()->forget('access_token');
        $clearRefresh = cookie()->forget('refresh_token');

        return response()->json([
            'message' => 'Logout correcto'
        ])->withCookie($clearAccess)
          ->withCookie($clearRefresh);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'No se pudo cerrar sesión'
        ], 400);
    }
}

}
