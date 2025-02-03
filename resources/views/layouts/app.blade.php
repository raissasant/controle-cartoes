<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Controle de Cartões</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        /* Cor do menu lateral (cinza médio) */
        .main-sidebar {
            background-color: #dee2e6 !important; /* Cinza médio mais escuro */
        }

        /* Ajuste da navbar */
        .navbar-light {
            background-color: #ffffff !important;
            border-bottom: 1px solid #ddd;
        }

        /* Nome do usuário na navbar (canto direito) */
        .user-info {
            font-weight: bold;
            margin-right: 10px;
            color: #343a40;
        }

        /* Botão de logout menor e elegante */
        .btn-logout {
            background: #dc3545;
            color: white;
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: #c82333;
        }

        /* Ícones do menu lateral vermelhos */
        .nav-sidebar .nav-icon {
            color: #dc3545 !important; /* Vermelho */
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
        <div class="container-fluid d-flex justify-content-between">
            <div></div> <!-- Espaço vazio para alinhar -->
            <div class="d-flex align-items-center">
                @auth
                    <span class="user-info">
                        <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                    </span>
                    <a href="{{ route('logout') }}" class="btn btn-logout">
                        <i class="bi bi-box-arrow-right"></i> Sair
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Menu Lateral -->
    @auth
    @php
        // Definir os usuários que podem visualizar os logs (apenas a parte antes do @)
        $usuariosPermitidos = [
            'raissa.adm',
            'ricardo.adm',
            'jose.adm'
        ];

        // Obtém apenas o nome de usuário antes do "@"
        $username = explode('@', auth()->user()->email)[0];
    @endphp

    <aside class="main-sidebar sidebar-light-primary elevation-4">
        <a href="#" class="brand-link text-center">
            <span class="brand-text font-weight-bold text-dark">Controle de Cartões</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="{{ route('cartaos.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-credit-card"></i>
                            <p>Meus Cartões</p>
                        </a>
                    </li>

                    <!-- Apenas os usuários permitidos podem ver os logs -->
                    @if(in_array($username, $usuariosPermitidos))
                        <li class="nav-item">
                            <a href="{{ route('logs.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list-check"></i>
                                <p>Logs</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </aside>
    @endauth

    <!-- Conteúdo Principal -->
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid pt-3">
                @yield('content')
            </div>
        </section>
    </div>

    <!-- AdminLTE Scripts -->
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</div>
</body>
</html>
