@extends('layouts.auth') {{-- Agora usa o layout correto --}}

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4 rounded text-center" style="width: 400px; background: #ffffff; border: 1px solid #ddd;">
        
        <!-- Logo da Empresa -->
        <div class="d-flex justify-content-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo da Empresa" style="width: 150px; margin-bottom: 15px;">
        </div>

        <h3 class="fw-bold text-dark">Acessar o Sistema</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Erro!</strong> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Campo de Login (E-mail ou Nome de Usuário) -->
            <div class="mb-3 text-start">
                <label for="email" class="form-label fw-bold text-dark">E-mail ou Usuário</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="text" id="email" name="email" class="form-control" 
                           placeholder="Digite seu e-mail ou usuário" required autofocus>
                </div>
            </div>

            <!-- Campo Senha -->
            <div class="mb-3 text-start">
                <label for="password" class="form-label fw-bold text-dark">Senha</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Digite sua senha" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="bi bi-eye-slash"></i>
                    </button>
                </div>
            </div>

            <!-- Botão Login -->
            <div class="d-grid">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-box-arrow-in-right"></i> Entrar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Footer fixo e centralizado -->
<footer class="text-center text-dark py-3" style="
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    background: #f8f9fa;
    border-top: 1px solid #ddd;">
    &copy; {{ date('Y') }} Controle de Cartões - Agroaraçá Alimentos Ltda.
</footer>

<!-- Script para mostrar/ocultar senha -->
<script>
    document.getElementById("togglePassword").addEventListener("click", function() {
        let passwordField = document.getElementById("password");
        let icon = this.querySelector("i");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        } else {
            passwordField.type = "password";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        }
    });
</script>
@endsection
