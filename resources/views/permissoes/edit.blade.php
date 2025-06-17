@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Permissão</h2>

    {{-- Mensagens de erro --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulário de edição --}}
    <form action="{{ route('permissoes.update', $permissao) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $permissao->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Permissão:</label>
            <input type="text" name="tipo" id="tipo" class="form-control" value="{{ old('tipo', $permissao->tipo) }}" required>
            <small class="form-text text-muted">Exemplos: <code>cartoes</code>, <code>oficios</code></small>
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="{{ route('permissoes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
