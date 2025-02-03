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
use App\Helpers\LogHelper; // Importa o LogHelper para registrar atividades

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
            'email' => 'required|string', // Agora aceita nomes de usuário e e-mails
            'password' => 'required'
        ]);

        $loginInput = $request->input('email');
        $password = $request->password;

        // Se o usuário digitou apenas o nome (sem "@"), adicionamos o domínio automaticamente
        if (!str_contains($loginInput, '@')) {
            $email = $loginInput . '@agroaraca.com.br';
        } else {
            $email = $loginInput; // Usuário digitou o e-mail completo
        }

        // Pega apenas o nome de usuário antes do "@"
        $username = explode('@', $email)[0];

        // Formata o nome de usuário para o Active Directory
        $ldapUsername = "AGROARACA\\" . $username;

        try {
            // Conectar ao LDAP
            $ldap = Container::getDefaultConnection();
            $ldap->connect();

            // Autenticação no AD
            if ($ldap->auth()->attempt($ldapUsername, $password)) {
                
                // Buscar usuário no LDAP pelo e-mail
                $ldapUser = LdapUser::where('mail', $email)->firstOrFail();

                // Criar ou atualizar o usuário no banco de dados Laravel
                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $ldapUser->getFirstAttribute('cn'),
                        'password' => Hash::make(Str::random(16)), // Senha aleatória para manter compatibilidade
                    ]
                );

                // Autenticar o usuário no Laravel
                Auth::login($user);

                // 🔹 Registra o log do login
                LogHelper::logAction('login', 'Usuário ' . $user->email . ' fez login com sucesso.');

                return redirect()->route('cartaos.index')->with('success', 'Login realizado com sucesso via Active Directory!');
            }

            // 🔹 Registra erro de autenticação no log
            LogHelper::logAction('failed_login', 'Falha na autenticação do Active Directory para ' . $email);

            return back()->withErrors(['email' => 'Falha na autenticação do Active Directory.']);
        } catch (ModelNotFoundException $e) {
            // 🔹 Registra erro de usuário não encontrado no log
            LogHelper::logAction('failed_login', 'Usuário não encontrado no Active Directory: ' . $email);

            return back()->withErrors(['email' => 'Usuário não encontrado no Active Directory.']);
        } catch (BindException $e) {
            // 🔹 Registra erro de conexão com o AD no log
            LogHelper::logAction('ldap_error', 'Erro ao conectar ao Active Directory: ' . $e->getMessage());

            return back()->withErrors(['email' => 'Erro ao conectar ao Active Directory.']);
        }

        // Se não encontrou no LDAP, verifica no banco de dados Laravel
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();

            // 🔹 Registra o log do login no banco de dados
            LogHelper::logAction('login', 'Usuário ' . $user->email . ' fez login pelo banco de dados.');

            return redirect()->route('cartaos.index')->with('success', 'Login realizado com sucesso!');
        }

        // 🔹 Registra erro de login inválido no log
        LogHelper::logAction('failed_login', 'Tentativa de login inválida para ' . $email);

        return back()->withErrors(['email' => 'Credenciais inválidas.']);
    }

    // Faz logout do usuário
    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            // 🔹 Registra o log do logout
            LogHelper::logAction('logout', 'Usuário ' . $user->email . ' fez logout.');
        }

        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout realizado.');
    }
}
