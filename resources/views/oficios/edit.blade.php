@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Motivo do Ofício</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('oficios.update', $oficio->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Número do Ofício (somente leitura) -->
        <div class="form-group mb-3">
            <label>Número do Ofício:</label>
            <input type="text" class="form-control" value="{{ $oficio->numero_oficio }}" disabled>
        </div>

        <!-- Setor (somente leitura) -->
        <div class="form-group mb-3">
            <label>Setor:</label>
            <input type="text" class="form-control" value="{{ $oficio->setor }}" disabled>
        </div>

        <!-- Data de uso (somente leitura) -->
        <div class="form-group mb-3">
            <label>Data de Uso:</label>
            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($oficio->data_uso)->format('d/m/Y') }}" disabled>
        </div>

        <!-- Responsável (somente leitura) -->
        <div class="form-group mb-3">
            <label>Responsável:</label>
            <input type="text" class="form-control" value="{{ $oficio->responsavel }}" disabled>
        </div>

        <!-- Motivo (editável) -->
        <div class="form-group mb-3">
            <label>Motivo:</label>
            <textarea name="motivo" class="form-control" rows="4">{{ $oficio->motivo }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="{{ route('oficios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
