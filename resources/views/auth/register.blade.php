@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Cadastro</h2>

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Senha:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirme a Senha:</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Registrar</button>
    </form>
</div>
@endsection
