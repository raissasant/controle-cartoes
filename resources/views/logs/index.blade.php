@extends('layouts.app')

@section('content')
@php
    // Lista de usuários permitidos a visualizar os logs
    $usuariosPermitidos = [
        'raissa.adm@agroaraca.com.br',
        'ricardo.adm@agroaraca.com.br',
        'jose.adm@agroaraca.com.br'
    ];
@endphp

@if(in_array(auth()->user()->email, $usuariosPermitidos))
    <div class="container mt-4">
        <div class="card shadow">
            <!-- Cabeçalho com cor azul mais suave -->
            <div class="card-header text-dark text-center" style="background-color: #e3f2fd;">
                <h3 class="mb-0">Registro de Atividades</h3>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="bg-light text-dark">
                            <tr>
                                <th class="bg-primary text-white">Usuário</th>
                                <th class="bg-info text-white">Ação</th>
                                <th class="bg-secondary text-white">Detalhes</th>
                                <th class="bg-dark text-white">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr class="bg-light">
                                <td class="align-middle">
                                    <i class="bi bi-person-circle text-primary"></i>
                                    {{ $log->user ? $log->user->name : 'Usuário Desconhecido' }}
                                </td>
                                <td class="align-middle">
                                    @if(str_contains($log->action, 'Criou'))
                                        <span class="badge bg-success">
                                            <i class="bi bi-plus-circle"></i> {{ $log->action }}
                                        </span>
                                    @elseif(str_contains($log->action, 'Editou'))
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-pencil-square"></i> {{ $log->action }}
                                        </span>
                                    @elseif(str_contains($log->action, 'Excluiu'))
                                        <span class="badge bg-danger">
                                            <i class="bi bi-trash"></i> {{ $log->action }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-info-circle"></i> {{ $log->action }}
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $log->details }}</td>
                                <td class="align-middle">
                                    <i class="bi bi-calendar-check text-dark"></i>
                                    {{ \Carbon\Carbon::parse($log->created_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação estilizada -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $logs->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@else
    <!-- Mensagem para usuários sem permissão -->
    <div class="container mt-5 text-center">
        <h4 class="text-danger">Acesso Negado</h4>
        <p>Você não tem permissão para visualizar os registros de atividades.</p>
    </div>
@endif
@endsection
