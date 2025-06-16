<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartaoController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\OficioController;
use App\Http\Controllers\PermissaoController;

// Página inicial
Route::get('/', function () {
    return view('welcome');
});

// 🔓 Rotas públicas (Login e Registro)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// 🔐 Rotas protegidas (usuários autenticados)
Route::middleware(['auth'])->group(function () {

    // 🔒 Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // 📊 Dashboard - apenas Admins
    Route::get('/dashboard', [OficioController::class, 'dashboard'])
        ->middleware('check.permissao:dashboard')
        ->name('dashboard');

    // ⚙️ Permissões (apenas Admins)
    Route::resource('permissoes', PermissaoController::class)
        ->parameters(['permissoes' => 'permissao']) // <-- Corrigido aqui
        ->except(['show'])
        ->middleware('check.permissao:dashboard');

    // 💳 Cartões - Admins ou usuários com permissão
    Route::middleware(['check.permissao:cartoes'])->group(function () {
        Route::resource('cartaos', CartaoController::class);
    });

    // 📝 Ofícios - Admins ou usuários com permissão
    Route::middleware(['check.permissao:oficios'])->group(function () {
        Route::get('/oficios', [OficioController::class, 'index'])->name('oficios.index');
        Route::get('/oficios/create', [OficioController::class, 'create'])->name('oficios.create');
        Route::post('/oficios', [OficioController::class, 'store'])->name('oficios.store');
        Route::get('/oficios/{id}/edit', [OficioController::class, 'edit'])->name('oficios.edit');
        Route::put('/oficios/{id}', [OficioController::class, 'update'])->name('oficios.update');
        Route::delete('/oficios/{id}', [OficioController::class, 'destroy'])->name('oficios.destroy');
    });

    // 📜 Logs - Apenas Admins via middleware dedicado
    Route::middleware(['logs.only'])->group(function () {
        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
    });
});



/* Rotas antigas

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartaoController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\OficioController; // ✅ Controller de Ofícios

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

        // 📄 Rotas de Ofícios (NOVO MÓDULO)
        Route::get('/oficios', [OficioController::class, 'index'])->name('oficios.index');
        Route::get('/oficios/create', [OficioController::class, 'create'])->name('oficios.create');
        Route::post('/oficios', [OficioController::class, 'store'])->name('oficios.store');
    });

*/
