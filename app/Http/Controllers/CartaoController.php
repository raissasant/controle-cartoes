<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cartao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogHelper; // Importa o LogHelper para registrar atividades

class CartaoController extends Controller
{
    // Exibe a lista de cartões
    public function index()
    {
        $cartaos = Cartao::all();
        return view('cartaos.index', compact('cartaos'));
    }

    // Exibe o formulário de criação
    public function create()
    {
        return view('cartaos.create');
    }

    // Processa a criação de um novo cartão
    public function store(Request $request)
    {
        $request->validate([
            'nome_granja' => 'required',
            'cidade' => 'required',
            'tecnico' => 'required',
            'status' => 'required',
        ]);

        $cartao = Cartao::create($request->all());

        // 🔹 Registra o log da criação do cartão
        LogHelper::logAction('create', 'Usuário ' . Auth::user()->email . ' criou um novo cartão (ID: ' . $cartao->id . ')');

        return redirect()->route('cartaos.index')->with('success', 'Cartão cadastrado com sucesso!');
    }

    // Exibe o formulário de edição
    public function edit(Cartao $cartao)
    {
        return view('cartaos.edit', compact('cartao'));
    }

    // Processa a atualização de um cartão
    public function update(Request $request, Cartao $cartao)
    {
        $cartao->update($request->all());

        // 🔹 Registra o log da edição do cartão
        LogHelper::logAction('edit', 'Usuário ' . Auth::user()->email . ' editou o cartão (ID: ' . $cartao->id . ')');

        return redirect()->route('cartaos.index')->with('success', 'Cartão atualizado com sucesso!');
    }

    // Processa a exclusão de um cartão
    public function destroy(Cartao $cartao)
    {
        $cartao->delete();

        // 🔹 Registra o log da exclusão do cartão
        LogHelper::logAction('delete', 'Usuário ' . Auth::user()->email . ' excluiu o cartão (ID: ' . $cartao->id . ')');

        return redirect()->route('cartaos.index')->with('success', 'Cartão excluído com sucesso!');
    }
}
