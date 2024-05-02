<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Address;
use App\Actions\Fortify\CreateNewUser;

class UserController extends Controller
{
    /**
     * Mostra a lista de usuários.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Realiza a solicitação de registro.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Actions\Fortify\CreateNewUser  $create
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, CreateNewUser $create)
    {
        //Valida as informações fornecidas e cria o usuário
        $security_code = $create->create($request->all());

        //Mensagem de sucesso
        return response()->json(
            [
                'message' => 'Usuario Registrado com sucesso!
                 Anote seu codigo de segurança',
                'security_code' => $security_code->two_factor_secret
            ],
            201
        );
    }

    public function addresses(Request $request)
    {
        // Acessa o usuário autenticado
        $userId = $request->user()->id;

        // Buscar endereços diretamente pelo user_id
        $addresses = Address::where('user_id', $userId)->get();

        // Checar se encontrou algum endereço
        if ($addresses->isEmpty()) {
            return response()->json(['message' => 'Não foi encontrado endereço para esse usuário'], 404);
        }

        // Retorna os endereços em formato JSON
        return response()->json($addresses);
    }


    /**
     * Atualiza as informações de cadastro do usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {

        //Valida se os campos fornecidos então dentro dos requisitos
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'confirm_password' => 'nullable|string|min:8',
        ]);

        // Se não passar no teste de validação retorna erro
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Se houver novo um nome, atualiza
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        // Se houver um novo email, atualiza
        if ($request->has('email')) {
            $user->email = $request->email;
        }

        // Se houver uma nova senha e se ela conferir com a senha de confirmação, atualiza
        if ($request->has('password') && ($request->password == $request->confirm_password)) {
            $user->password = Hash::make($request->password);
        }

        // Atualiza as novas informações no banco de dados
        $user->save();

        // Retorna as informações atualizadas
        return response()->json($user);
    }
}
