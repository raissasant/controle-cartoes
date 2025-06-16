@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cadastrar Novo Ofício</h2>

    {{-- Erros de validação --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    <!@endif

    {{-- Número sugerido de ofício --}}
    @if(isset($numeroFormatado))
        <div class="alert alert-info">
            <strong>Próximo número sugerido:</strong> {{ $numeroFormatado }}
        </div>
    @endif

    <form action="{{ route('oficios.store') }}" method="POST">
        @csrf

        <!-- Número do Ofício 
        <div class="form-group mb-3">
            <label>Número do Ofício (opcional):</label>
            <input type="number" name="numero_oficio" class="form-control" placeholder="Deixe em branco para gerar automaticamente" value="{{ old('numero_oficio') }}">
            @if(isset($numeroFormatado))
                <small class="form-text text-muted">Sugerido: {{ $numeroFormatado }}</small>
            @endif
        </div> -->

        <!-- Setor -->
        <div class="form-group mb-3">
            <label>Setor:</label>
            <select name="setor" class="form-control" required>
                <option value="">Selecione</option>
                <option value="Qualidade" {{ old('setor') == 'Qualidade' ? 'selected' : '' }}>Qualidade</option>
                <option value="RH" {{ old('setor') == 'RH' ? 'selected' : '' }}>RH</option>
                <option value="Fomento" {{ old('setor') == 'Fomento' ? 'selected' : '' }}>Fomento</option>
                <option value="Juridico" {{ old('setor') == 'Juridico' ? 'selected' : '' }}>Jurídico</option>
                <option value="Faturamento" {{ old('setor') == 'Faturamento' ? 'selected' : '' }}>Faturamento</option>
            </select>
        </div>

        <!-- Data de Uso -->
        <div class="form-group mb-3">
            <label>Data de uso:</label>
            <input type="date" name="data_uso" class="form-control" value="{{ old('data_uso', $dataAtual) }}" required>
        </div>

        <!-- Responsável -->
        <div class="form-group mb-3">
            <label>Responsável:</label>
            <input type="text" name="responsavel" class="form-control" value="{{ old('responsavel') }}">
        </div>

        <!-- Motivo -->
        <div class="form-group mb-3">
            <label>Motivo:</label>
            <textarea name="motivo" class="form-control" rows="4">{{ old('motivo') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Salvar Ofício</button>
        <a href="{{ route('oficios.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
