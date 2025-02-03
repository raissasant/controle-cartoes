<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index()
    {
        // Definir os usuários que podem acessar os logs
        $usuariosPermitidos = [
            'raissa.adm@agroaraca.com.br',
            'ricardo.adm@agroaraca.com.br',
            'jose.adm@agroaraca.com.br',
            'raissa.adm',
            'ricardo.adm',
            'jose.adm'
        ];
        

        // Verifica se o usuário atual está na lista de permitidos
        if (!in_array(Auth::user()->email, $usuariosPermitidos)) {
            abort(403, 'Acesso negado.');
        }

        // Se o usuário estiver autorizado, carrega os logs
        $logs = Log::with('user')->latest()->paginate(10);
        return view('logs.index', compact('logs'));
    }
}
