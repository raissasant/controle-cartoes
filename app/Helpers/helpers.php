<?php

use App\Models\Permissao;

if (!function_exists('usuarioEhAdmin')) {
    function usuarioEhAdmin(): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        $admins = [
            'raissa.adm@agroaraca.com.br',
            'ricardo.adm@agroaraca.com.br',
            'jose.adm@agroaraca.com.br',
        ];

        return in_array(strtolower($user->email), array_map('strtolower', $admins));
    }
}

if (!function_exists('usuarioTemPermissao')) {
    function usuarioTemPermissao(string $tipo): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        if (usuarioEhAdmin()) return true;

        return \App\Models\Permissao::where('email', $user->email)
            ->where('tipo', $tipo)
            ->exists();
    }
}
