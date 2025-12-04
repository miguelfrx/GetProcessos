<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // Mostrar o formulário de login
    public function showLogin()
    {
        return view('login'); // Vai carregar resources/views/login.blade.php
    }

    // Processar o formulário de login
    public function login(Request $request)
    {
        // Validar dados
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Tentar fazer login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();  // segurança
            return redirect('/paginamain');       // para onde direciona o login
        }

        // Se falhar, voltar com erro
        return back()->withErrors([
            'email' => 'Email ou password incorretos.',
        ]);
    }

    // Mostrar o formulário de registro
    public function showRegister() {
        return view('register');
    }

    // Processar o formulário de registro
    public function register(Request $request) {
        // Validação básica
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Criar o usuário
        User::create([
            'name' => explode('@', $request->email)[0], // pega a primeira parte do email como nome
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/')->with('success', 'Conta criada com sucesso! Faça login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
