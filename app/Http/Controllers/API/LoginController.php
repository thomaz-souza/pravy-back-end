<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Credenciais Invalidas.'], 401);
        }

        // Verificar se o 2FA está habilitado
        if ($user->two_factor_secret) {
            // Gerar um token temporário que requer 2FA para ser confirmado
            $temporaryToken = $user->createToken('Temporary Token', ['2fa'])->plainTextToken;

            return response()->json([
                'message' => '2FA required',
                'user_id' => $user->id,
                'temporary_token' => $temporaryToken,
            ], 200);
        }

        return response()->json([
            'message' => 'Não autorizado',
        ], 403);
    }

    public function storeTwoFactor(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'code' => 'required|string',
            'temporary_token' => 'required|string'
        ]);

        $user = User::findOrFail($request->user_id);

        // Assegurar que o usuário autenticado é o mesmo que o ID fornecido (prevenindo troca de usuário)
        if ($user->id == auth()->id()) {
            return response()->json(['error' => 'Acesso nao autorizado.'], 403);
        }

        // Aqui você precisaria de lógica para verificar o código 2FA
        if ($user->two_factor_secret == $request->code) {
            $user->tokens()->where('id', Auth::guard('sanctum')->id())->delete(); // Revogar o token temporário
            $token = $user->createToken('API Token')->plainTextToken; // Emitir novo token definitivo

            return response()->json([
                'message' => '2FA verification successful. Full access granted.',
                'token' => $token,
            ], 200);
        } else {
            return response()->json(['error' => 'Codigo 2FA invalido.'], 401);
        }
    }

    public function logout(Request $request)
    {
        // Revoga todos os tokens do usuário
        $request->user()->tokens()->delete();

        // Resposta JSON de sucesso
        return response()->json([
            'success' => true,
            'message' => 'Logout realizado com sucesso.'
        ]);
    }
}
