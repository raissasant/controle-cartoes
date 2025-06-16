<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;
use LdapRecord\Auth\BindException;
use LdapRecord\Container;
use LdapRecord\Models\ModelNotFoundException;
use Illuminate\Support\Str;
use App\Helpers\LogHelper;

class AuthController extends Controller
{
    // Exibe o formulário de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Processa o login (LDAP + Banco de Dados)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required'
        ]);

        $loginInput = $request->input('email');
        $password = $request->password;

        $email = str_contains($loginInput, '@') ? $loginInput : $loginInput . '@agroaraca.com.br';
        $username = explode('@', $email)[0];
        $ldapUsername = "AGROARACA\\" . $username;

        try {
            $ldap = Container::getDefaultConnection();
            $ldap->connect();

            if ($ldap->auth()->attempt($ldapUsername, $password)) {
                $ldapUser = LdapUser::where('mail', $email)->firstOrFail();

                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $ldapUser->getFirstAttribute('cn'),
                        'password' => Hash::make(Str::random(16)), // senha aleatória
                    ]
                );

                Auth::login($user);

                LogHelper::logAction('login', 'Usuário ' . $user->email . ' fez login com sucesso via LDAP.');

                return $this->redirectBasedOnPermissions($user);
            }

            LogHelper::logAction('failed_login', 'Falha na autenticação LDAP para ' . $email);
            return back()->withErrors(['email' => 'Falha na autenticação do Active Directory.']);

        } catch (ModelNotFoundException $e) {
            LogHelper::logAction('failed_login', 'Usuário não encontrado no AD: ' . $email);
            return back()->withErrors(['email' => 'Usuário não encontrado no Active Directory.']);
        } catch (BindException $e) {
            LogHelper::logAction('ldap_error', 'Erro ao conectar no AD: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Erro ao conectar ao Active Directory.']);
        }

        // Tentativa via banco de dados Laravel
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();

            LogHelper::logAction('login', 'Usuário ' . $user->email . ' fez login via banco de dados.');

            return $this->redirectBasedOnPermissions($user);
        }

        LogHelper::logAction('failed_login', 'Login inválido para ' . $email);
        return back()->withErrors(['email' => 'Credenciais inválidas.']);
    }

    // Faz logout do usuário
    public function logout()
    {
        $user = Auth::user();

        if ($user) {
            LogHelper::logAction('logout', 'Usuário ' . $user->email . ' fez logout.');
        }

        Auth::logout();

        return redirect()->route('login')->with('success', 'Logout realizado.');
    }

    // Redireciona com base nas permissões
    private function redirectBasedOnPermissions($user)
    {
        if (usuarioEhAdmin()) {
            \Log::info('🔐 Admin autenticado', ['email' => $user->email]);
            return redirect()->route('dashboard')->with('success', 'Login realizado com sucesso!');
        }

        if (usuarioTemPermissao('cartoes')) {
            \Log::info('✅ Permissão detectada: cartoes', ['email' => $user->email]);
            return redirect()->route('cartaos.index')->with('success', 'Login realizado com sucesso!');
        }

        if (usuarioTemPermissao('oficios')) {
            \Log::info('✅ Permissão detectada: oficios', ['email' => $user->email]);
            return redirect()->route('oficios.index')->with('success', 'Login realizado com sucesso!');
        }

        \Log::warning('🚫 Usuário sem permissão em nenhum módulo', ['email' => $user->email]);
        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Você não tem permissão para acessar nenhum módulo.']);
    }
}
