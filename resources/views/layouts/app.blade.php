<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal de Controle</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        .main-sidebar {
            background-color: #dee2e6 !important;
        }

        .navbar-light {
            background-color: #ffffff !important;
            border-bottom: 1px solid #ddd;
        }

        .user-info {
            font-weight: bold;
            margin-right: 10px;
            color: #343a40;
        }

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

        .nav-sidebar .nav-icon {
            color: #dc3545 !important;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
        <div class="container-fluid d-flex justify-content-between">
            <div></div>
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
    <aside class="main-sidebar sidebar-light-primary elevation-4">
        <a href="#" class="brand-link text-center">
            <span class="brand-text font-weight-bold text-dark">Portal de Controle</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                    <!-- Meus Cartões -->
                    @if(usuarioEhAdmin() || usuarioTemPermissao('cartoes'))
                    <li class="nav-item">
                        <a href="{{ route('cartaos.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-credit-card"></i>
                            <p>Meus Cartões</p>
                        </a>
                    </li>
                    @endif

                    <!-- Ofícios -->
                    @if(usuarioEhAdmin() || usuarioTemPermissao('oficios'))
                    <li class="nav-item">
                        <a href="{{ route('oficios.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-journal-text"></i>
                            <p>Ofícios</p>
                        </a>
                    </li>
                    @endif

                    <!-- Dashboard -->
                    @if(usuarioEhAdmin())
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="nav-icon bi bi-bar-chart-line"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    @endif

                    <!-- Logs -->
                    @if(usuarioEhAdmin())
                    <li class="nav-item">
                        <a href="{{ route('logs.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-list-check"></i>
                            <p>Logs</p>
                        </a>
                    </li>
                    @endif

                    <!-- Permissões -->
                    @if(usuarioEhAdmin())
                    <li class="nav-item">
                        <a href="{{ route('permissoes.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-shield-lock"></i>
                            <p>Permissões</p>
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

        <!-- Tooltips Bootstrap + Ocultar mensagens -->
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Ocultar alertas de sucesso após 2.5 segundos
            const alerts = document.querySelectorAll('.alert-success.alert-dissmissible');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 2500);
            });
        });
    </script>


</div>
</body>
</html>
