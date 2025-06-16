<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $tipo): Response
    {
        $user = auth()->user();
        if (!$user) {
            abort(403, 'Acesso negado. Faça login.');
        }

        if (usuarioEhAdmin() || usuarioTemPermissao($tipo)) {
            return $next($request);
        }

        abort(403, 'Você não tem permissão para acessar este módulo.');
    }
}
