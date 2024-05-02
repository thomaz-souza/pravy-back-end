<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{

    /**
     * Realiza o login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request)
    {
        //Valida as informações de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Realiza a busca pelo usuário a partir do email
        $user = User::where('email', $request->email)->first();

        // Valida se é nulo ou se a senha não conferir retorna erro
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

        //Retorna se não passar por nenhuma das validação
        return response()->json([
            'message' => 'Não autorizado',
        ], 403);
    }

    /**
     * Realiza a solicitação do token autenticando o usuário em 2FA.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeTwoFactor(Request $request)
    {
        //Valida as informações de entrada
        $request->validate([
            'user_id' => 'required|integer',
            'code' => 'required|string',
            'temporary_token' => 'required|string'
        ]);

        // Procura pelo usuário utilizando o ID
        $user = User::findOrFail($request->user_id);

        // Assegura que o usuário autenticado é o mesmo que o ID fornecido (prevenindo troca de usuário)
        if ($user->id == auth()->id()) {
            return response()->json(['error' => 'Acesso nao autorizado.'], 403);
        }

        // Verifica se o código 2FA é o mesmo que o fornecido
        if ($user->two_factor_secret == $request->code) {
            $user->tokens()->where('id', Auth::guard('sanctum')->id())->delete(); // Revoga o token temporário
            $token = $user->createToken('API Token')->plainTextToken; // Emite novo token definitivo

            return response()->json([
                'message' => '2FA verification successful. Full access granted.',
                'token' => $token,
            ], 200);
        }
        return response()->json(['error' => 'Codigo 2FA invalido.'], 401);
    }

    public function logout(Request $request)
    {
        // Revoga todos os tokens do usuário
        $request->user()->tokens()->delete();

        // Resposta JSON de sucesso
        return response()->json([
            'success' => true,
            'message' => 'Logout realizado com sucesso.'
        ], 200);
    }
}
