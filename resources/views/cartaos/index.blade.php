@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <!-- Cabeçalho agora sem fundo preto -->
        <div class="card-header bg-white text-dark text-center border-bottom">
            <h3 class="mb-0">Todos os Cartões Cadastrados</h3>
        </div>

        <div class="card-body">
            <!-- Tabela Responsiva -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <!-- Cabeçalho da Tabela com Cor Suave -->
                    <thead class="bg-light text-dark">
                        <tr>
                            <th class="bg-primary text-white">Nome Granja</th>
                            <th class="bg-info text-white">Cidade</th>
                            <th class="bg-success text-white">Técnico</th>
                            <th class="bg-warning text-dark">PIN</th>
                            <th class="bg-danger text-white">PUK</th>
                            <th class="bg-secondary text-white">Validade</th>
                            <th class="bg-dark text-white">Status</th>
                            <th class="bg-light text-dark">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartaos as $cartao)
                        <tr class="bg-light"> <!-- Fundo suave para destaque -->
                            <td class="fw-bold align-middle">{{ $cartao->nome_granja }}</td>
                            <td class="align-middle">{{ $cartao->cidade }}</td>
                            <td class="align-middle">{{ $cartao->tecnico }}</td>
                            <td class="align-middle">{{ $cartao->pin }}</td>
                            <td class="align-middle">{{ $cartao->puk }}</td>
                            <td class="align-middle">
                                @if($cartao->validade)
                                    {{ \Carbon\Carbon::parse($cartao->validade)->format('d/m/Y') }}
                                @else
                                    <span class="badge bg-secondary text-white">Sem Data</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @php
                                    $hoje = \Carbon\Carbon::now();
                                    $diasParaVencer = $cartao->validade ? $hoje->diffInDays(\Carbon\Carbon::parse($cartao->validade), false) : null;
                                @endphp

                                @if($cartao->status == 'Expirado')
                                    <span class="badge bg-danger">Expirado</span>
                                @elseif($cartao->status == 'Bloqueado')
                                    <span class="badge bg-secondary">Bloqueado</span>
                                @elseif($diasParaVencer !== null && $diasParaVencer <= 7 && $diasParaVencer > 0)
                                    <span class="badge bg-warning text-dark">Perto de Vencer</span>
                                @elseif($cartao->status == 'Ativo')
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-light text-dark">Indefinido</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('cartaos.edit', $cartao->id) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                    <form action="{{ route('cartaos.destroy', $cartao->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Botão "Novo Cartão" no final, menor -->
            <div class="d-flex justify-content-center mt-4">
                <a href="{{ route('cartaos.create') }}" class="btn btn-primary btn-sm px-4 py-2">
                    <i class="bi bi-plus-lg"></i> Novo Cartão
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
