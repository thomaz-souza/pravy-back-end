<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Certifique-se de que o modelo User está sendo usado

class UserController extends Controller
{
    // Método para listar usuários
    public function index()
    {
        return view('/users/users');
    }

    // Método para mostrar o formulário de criar novo usuário
    public function create()
    {
    }

    // Método para salvar o novo usuário no banco de dados
    public function store(Request $request)
    {
    }

    // Método para mostrar o formulário de edição de usuário
    public function edit(User $user)
    {
    }

    // Método para atualizar o usuário no banco de dados
    public function update(Request $request, User $user)
    {
    }
}
