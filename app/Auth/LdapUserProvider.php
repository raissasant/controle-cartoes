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
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Converte o e-mail para o formato correto do AD
        $email = $request->email;
        $username = str_replace("@agroaraca.com.br", "", $email) . "@agroaraca.local"; // Usuário no formato correto do AD
        $password = $request->password;

        try {
            // Conecta ao servidor LDAP
            $ldap = Container::getDefaultConnection();
            $ldap->connect();

            // Busca o usuário no LDAP pelo e-mail
            $ldapUser = LdapUser::where('mail', $email)->firstOrFail();

            // Tenta autenticar no LDAP
            if ($ldap->auth()->attempt($username, $password)) {
                // Se for autenticado no AD, registra ou atualiza no banco de dados do Laravel
                $user = User::updateOrCreate(
                    ['email' => $email],
                    ['name' => $ldapUser->getFirstAttribute('cn')] // Nome do usuário no AD
                );

                Auth::login($user);
                return redirect()->route('cartaos.index')->with('success', 'Login realizado com sucesso via Active Directory!');
            } else {
                return back()->withErrors(['email' => 'Falha na autenticação do Active Directory.']);
            }
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['email' => 'Usuário não encontrado no Active Directory.']);
        } catch (BindException $e) {
            return back()->withErrors(['email' => 'Erro ao conectar ao Active Directory.']);
        }

        // Se não encontrou no LDAP, verifica no banco de dados Laravel
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('cartaos.index')->with('success', 'Login realizado com sucesso!');
        }

        return back()->withErrors(['email' => 'Credenciais inválidas.']);
    }

    // Exibe o formulário de registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // Processa o registro (apenas banco de dados, sem LDAP)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso! Faça login.');
    }

    // Faz logout do usuário
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout realizado.');
    }
}
