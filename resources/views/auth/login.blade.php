@extends('layouts.app')


@section('title', 'Listar')

@section('content')
    <h2>Login</h2>
    <form method="POST" action="{{ url('/two-factor-challenge') }}">
        @csrf

        <div>
            <label for="code">Code from your authenticator app:</label>
            <input id="code" name="code" type="text" autofocus required>
        </div>

        <div>
            <button type="submit">Login</button>
        </div>
    </form>

@endsection
