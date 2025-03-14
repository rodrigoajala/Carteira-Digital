<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class AuthenticationTokenController extends Controller
{

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken('DigitalWalletToken');

            return response()->json([
                'access_token' => $token,
                'user' => $user,
                'message' => 'Login realizado com sucesso!'
            ]);

        }
        return response()->json([
            'success' => false,
            'message' => 'Unauthorised',
        ], 401);

    }
    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso!'
        ]);
    }
}
