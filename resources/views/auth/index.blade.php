@extends('layouts.app')


@section('title', 'Listar')

@section('content')
    <h1>Usuários</h1>
    <ul>
        @foreach ($users as $user)
            <li>{{ $user->name }} - {{ $user->email }}</li>
        @endforeach
    </ul>
@endsection
