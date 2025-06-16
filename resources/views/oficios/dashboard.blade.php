@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard de Ofícios</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="alert alert-info">
                <strong>Total de Ofícios:</strong> {{ $total }}
            </div>
        </div>

        <div class="col-md-4">
            <div class="alert alert-success">
                <strong>Últimos 30 dias:</strong> {{ $ultimoMes }}
            </div>
        </div>
    </div>

    <h4>Ofícios por Setor</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Setor</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($porSetor as $item)
            <tr>
                <td>{{ $item->setor }}</td>
                <td>{{ $item->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
