@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <!-- Cabeçalho com cor mais suave -->
        <div class="card-header text-dark text-center bg-light">
            <h3 class="mb-0">Editar Cartão</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('cartaos.update', $cartao->id) }}" method="POST">
                @csrf
                @method('PUT')

                <label class="mt-2">Nome Granja:</label>
                <input type="text" name="nome_granja" class="form-control" value="{{ $cartao->nome_granja }}" required>
                
                <label class="mt-2">Cidade:</label>
                <input type="text" name="cidade" class="form-control" value="{{ $cartao->cidade }}" required>

                <label class="mt-2">Técnico:</label>
                <input type="text" name="tecnico" class="form-control" value="{{ $cartao->tecnico }}" required>

                <label class="mt-2">PIN:</label>
                <input type="text" name="pin" class="form-control" value="{{ $cartao->pin }}">

                <label class="mt-2">PUK:</label>
                <input type="text" name="puk" class="form-control" value="{{ $cartao->puk }}">

                <label class="mt-2">Validade:</label>
                <input type="date" name="validade" class="form-control" value="{{ \Carbon\Carbon::parse($cartao->validade)->format('Y-m-d') }}">

                <label class="mt-2">Status:</label>
                <select name="status" class="form-control">
                    <option value="Ativo" {{ $cartao->status == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="Expirado" {{ $cartao->status == 'Expirado' ? 'selected' : '' }}>Expirado</option>
                    <option value="Bloqueado" {{ $cartao->status == 'Bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                    <option value="Devolvido" {{ $cartao->status == 'Devolvido' ? 'selected' : '' }}>Devolvido</option>
                    @if($cartao->status == 'Perto de Vencer')
                        <option value="Perto de Vencer" selected disabled>Perto de Vencer</option>
                    @endif
                </select>

                <!-- 🔹 Campo de Observações -->
                <label class="mt-2">Observação:</label>
                <textarea name="observacao" class="form-control" rows="3">{{ $cartao->observacao }}</textarea>

                <!-- Botões Atualizar e Cancelar no mesmo local -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle"></i> Atualizar
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
