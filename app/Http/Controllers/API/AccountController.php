<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;

class AccountController extends Controller
{
    public function register(UserRequest $request)
    {
        $user = User::create([
            'name'      => $request['name'],
            'email'     => $request['email'],
            'password'  => $request['password'],
        ]);

        return response()->json([
            'message' => 'Usuário criado com sucesso!',
            'user' => $user
        ]);
    }

    public function listUsers()
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Acesso não autorizado']);
        }

        $employees = User::where('role', 'employee')->get();
        return response()->json([
            'mensagem' => 'Usuarios listados com sucesso!',
            'users' => $employees
        ]);
    }

    public function me()
    {
        $user = auth()->user();
        return response()->json([
            'user' => $user
        ]);
    }

    public function addCredits($userId, $amount)
    {
        $users = User::find($userId);
        $user = auth()->user();

        if (!auth()->user() || auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Acesso não autorizado']);
        }

        if (!$user) {
            return response()->json(['mensage' => 'Usuario não encontrado']);
        }

        $users->credits += $amount;
        $users->save();

        return response()->json([
            'mensage' => 'Creditos adicionados com secesso',
            'user' => $users
        ]);
    }

}
