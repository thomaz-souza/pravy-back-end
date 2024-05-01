@extends('layouts.app')


@section('title', 'Editar')

@section('content')
    <h1>Editar Usuário</h1>
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <button type="submit">Update</button>
    </form>
@endsection


@section('content')
    <div class="container">

    </div>
@endsection
