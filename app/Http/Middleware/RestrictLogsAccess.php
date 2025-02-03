<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RestrictLogsAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // Lista de usuários permitidos (apenas o nome antes do @)
        $usuariosPermitidos = [
            'raissa.adm',
            'ricardo.adm',
            'jose.adm'
        ];

        // Garante que o usuário está logado
        if (!Auth::check()) {
            abort(403, 'Acesso negado.');
        }

        // Obtém o nome de usuário antes do "@"
        $email = Auth::user()->email;
        $username = explode('@', $email)[0]; // Pegando apenas a parte antes do "@"

        // Verifica se o usuário está na lista de permitidos
        if (!in_array($username, $usuariosPermitidos)) {
            abort(403, 'Acesso negado.');
        }

        return $next($request);
    }
}
