<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartaoController;
use App\Http\Controllers\LogController;

// Página inicial
Route::get('/', function () {
    return view('welcome');
});

// 🔓 Rotas públicas (Login, Registro)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// 🔐 Rotas protegidas (Apenas usuários logados podem acessar)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Recursos de Cartões (Todos os usuários podem acessar)
    Route::resource('cartaos', CartaoController::class);

    // 🚀 Proteção da rota dos logs com Middleware
    Route::middleware([\App\Http\Middleware\RestrictLogsAccess::class])->group(function () {
        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
    });
});
