@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nova Permissão</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('permissoes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tipo:</label>
            <input type="text" name="tipo" class="form-control" required>
            <small>Exemplo: cartoes, oficios, dashboard</small>
        </div>
        <button class="btn btn-success">Salvar</button>
        <a href="{{ route('permissoes.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
