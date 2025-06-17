@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Permissões</h2>

    {{-- Mensagem de sucesso com desaparecimento automático --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

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

    {{-- Formulário de pesquisa --}}
    <form method="GET" action="{{ route('permissoes.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Pesquisar por e-mail...">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>
    </form>

    {{-- Tabela de permissões --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Email</th>
                <th>Tipo de Permissão</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($permissoes as $permissao)
            <tr>
                <td>{{ $permissao->email }}</td>
                <td>{{ $permissao->tipo }}</td>
                <td>
                    <a href="{{ route('permissoes.edit', $permissao) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('permissoes.destroy', $permissao) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Deseja realmente excluir esta permissão?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Nenhuma permissão encontrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Botão Nova Permissão Centralizado --}}
    <div class="text-center mt-4">
        <a href="{{ route('permissoes.create') }}" class="btn btn-primary btn-sm px-4 py-2">
            <i class="bi bi-plus-lg"></i> Permissões
        </a>
    </div>
</div>

{{-- Script para ocultar a mensagem de sucesso após 2.5 segundos --}}
<script>
    setTimeout(function () {
        const alert = document.querySelector('.alert-success');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 2500);
</script>
@endsection

