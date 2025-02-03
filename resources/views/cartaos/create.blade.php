@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <!-- Cabeçalho com cor mais suave -->
        <div class="card-header text-dark text-center bg-light">
            <h3 class="mb-0">Novo Cartão</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('cartaos.store') }}" method="POST">
                @csrf
                
                <label class="mt-2">Nome Granja:</label>
                <input type="text" name="nome_granja" class="form-control" required>
                
                <label class="mt-2">Cidade:</label>
                <input type="text" name="cidade" class="form-control" required>

                <label class="mt-2">Técnico:</label>
                <input type="text" name="tecnico" class="form-control" required>

                <label class="mt-2">PIN:</label>
                <input type="text" name="pin" class="form-control">

                <label class="mt-2">PUK:</label>
                <input type="text" name="puk" class="form-control">

                <label class="mt-2">Validade:</label>
                <input type="date" name="validade" class="form-control">

                <label class="mt-2">Status:</label>
                <select name="status" class="form-control">
                    <option value="Ativo">Ativo</option>
                    <option value="Expirado">Expirado</option>
                    <option value="Bloqueado">Bloqueado</option>
                </select>

                <!-- Botões Salvar e Cancelar na mesma linha, como no Editar -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle"></i> Salvar
                    </button>
                    <a href="{{ route('cartaos.index') }}" class="btn btn-secondary px-4 ms-3">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
