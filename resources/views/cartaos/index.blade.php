@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <!-- Cabeçalho -->
        <div class="card-header bg-white text-dark text-center border-bottom">
            <h3 class="mb-0"> Cartões Cadastrados</h3>
        </div>

        <div class="card-body">
            <!-- 🔹 Campo de Pesquisa -->
            <form method="GET" action="{{ route('cartaos.index') }}" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Pesquisar por Nome, Cidade, Técnico, Status...">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
                </div>
            </form>

            <!-- Tabela Responsiva -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center" style="font-size: 13px;">
                    <!-- Cabeçalho da Tabela -->
                    <thead class="bg-light text-dark">
                        <tr>
                            <th class="bg-primary text-white" style="width: 12%;">Nome Granja</th>
                            <th class="bg-info text-white" style="width: 10%;">Cidade</th>
                            <th class="bg-success text-white" style="width: 10%;">Técnico</th>
                            <th class="bg-warning text-dark" style="width: 7%;">PIN</th>
                            <th class="bg-danger text-white" style="width: 7%;">PUK</th>
                            <th class="bg-secondary text-white" style="width: 9%;">Validade</th>
                            <th class="bg-dark text-white" style="width: 10%;">Status</th>
                            <th class="bg-warning text-dark" style="width: 15%;">Observação</th>
                            <th class="bg-light text-dark" style="width: 8%;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartaos as $cartao)
                        <tr class="bg-light">
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
                                    $validade = $cartao->validade ? \Carbon\Carbon::parse($cartao->validade) : null;
                                    $diasParaVencer = $validade ? $hoje->diffInDays($validade, false) : null;
                                @endphp

                                @if($cartao->status === 'Devolvido')
                                    <span class="badge bg-primary">Devolvido</span>
                                @elseif($cartao->status === 'Expirado' || ($cartao->status === 'Ativo' && $diasParaVencer < 0))
                                    <span class="badge bg-danger">Expirado</span>
                                @elseif($cartao->status === 'Bloqueado')
                                    <span class="badge bg-secondary">Bloqueado</span>
                                @elseif($cartao->status === 'Perto de Vencer' || ($cartao->status === 'Ativo' && $diasParaVencer !== null && $diasParaVencer <= 30 && $diasParaVencer > 0))
                                    <span class="badge bg-warning text-dark">Perto de Vencer</span>
                                @elseif($cartao->status === 'Ativo')
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if(!empty($cartao->observacao))
                                    <span class="badge bg-info text-white p-2">
                                        {{ $cartao->observacao }}
                                    </span>
                                @else
                                    <span class="text-muted">Sem observações</span>
                                @endif
                            </td>
                            <td class="align-middle">
    <div class="d-flex justify-content-center">
        <a href="{{ route('cartaos.edit', $cartao->id) }}" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="tooltip" title="Editar">
            <i class="bi bi-pencil-square"></i>
        </a>
        <form action="{{ route('cartaos.destroy', $cartao->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Excluir">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- 🔹 Botão "Novo Cartão" Centralizado -->
            <div class="text-center mt-4">
                <a href="{{ route('cartaos.create') }}" class="btn btn-primary btn-sm px-4 py-2">
                    <i class="bi bi-plus-lg"></i> Novo Cartão
                </a>
            </div>

           <!-- Paginação estilizada -->
           <div class="d-flex justify-content-center mt-3">
                    {{ $cartaos->links('pagination::bootstrap-4') }}
                </div>

        </div>
    </div>
</div>
@endsection
