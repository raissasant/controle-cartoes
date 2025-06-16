@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Permissões</h2>

    {{-- Mensagem de sucesso com desaparecimento automático --}}
    @if(session('success'))
        <div class="alert alert-success alert-dissmissible">
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
            @foreach ($permissoes as $permissao)
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
            @endforeach
        </tbody>
    </table>

    {{-- Botão para nova permissão --}}
    <a href="{{ route('permissoes.create') }}" class="btn btn-primary mt-3">+ Nova Permissão</a>
</div>
@endsection
