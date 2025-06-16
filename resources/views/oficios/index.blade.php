@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Lista de Ofícios</h2>

    {{-- Mensagem de sucesso com desaparecimento automático --}}
    @if(session('success'))
        <div class="alert alert-success alert-dissmissible">
            {{ session('success') }}
        </div>
    @endif

    @php
        $usuariosPermitidos = [
            'raissa.adm@agroaraca.com.br',
            'ricardo.adm@agroaraca.com.br',
            'jose.adm@agroaraca.com.br',
            'raissa.adm',
            'ricardo.adm',
            'jose.adm',
        ];
        $email = auth()->user()->email;
        $username = explode('@', $email)[0];
        $podeExcluir = in_array($email, $usuariosPermitidos) || in_array($username, $usuariosPermitidos);
    @endphp

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Número</th>
                <th>Setor</th>
                <th>Data de Uso</th>
                <th>Responsável</th>
                <th>Motivo</th>
                <th>Criado em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($oficios as $oficio)
            <tr>
                <td>{{ $oficio->numero_formatado }}</td>
                <td>{{ $oficio->setor }}</td>
                <td>{{ \Carbon\Carbon::parse($oficio->data_uso)->format('d/m/Y') }}</td>
                <td>{{ $oficio->responsavel }}</td>
                <td>{{ $oficio->motivo }}</td>
                <td>{{ $oficio->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('oficios.edit', $oficio->id) }}" class="btn btn-sm btn-warning">Editar</a>

                    @if($podeExcluir)
                    <form action="{{ route('oficios.destroy', $oficio->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Deseja realmente excluir este ofício?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('oficios.create') }}" class="btn btn-primary mt-3">+ Novo Ofício</a>
</div>
@endsection
