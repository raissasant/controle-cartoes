<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cartao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogHelper; // Importa o LogHelper para registrar atividades

class CartaoController extends Controller
{
    public function index(Request $request)
{
    $query = Cartao::query();

    // 🔹 Se houver pesquisa, filtra os cartões pelos campos relevantes
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('nome_granja', 'like', "%{$search}%")
              ->orWhere('cidade', 'like', "%{$search}%")
              ->orWhere('tecnico', 'like', "%{$search}%")
              ->orWhere('status', 'like', "%{$search}%")
              ->orWhere('observacao', 'like', "%{$search}%");
        });
    }

    // 🔹 Obtém todos os cartões sem paginação para atualizar os status no banco
    $cartaos = $query->get();

    foreach ($cartaos as $cartao) {
        if ($cartao->status === 'Ativo' && $cartao->validade) {
            $validade = Carbon::parse($cartao->validade);
            $hoje = Carbon::now();
            $diasParaVencer = $hoje->diffInDays($validade, false);

            if ($diasParaVencer > 0 && $diasParaVencer <= 30) {
                // Atualiza no banco para "Perto de Vencer"
                $cartao->update(['status' => 'Perto de Vencer']);
            } elseif ($validade->isPast()) {
                // Atualiza no banco para "Expirado" se a data já passou
                $cartao->update(['status' => 'Expirado']);
            }
        }
    }

    // 🔹 Obtém todos os cartões com paginação após atualização
    $cartaos = $query->paginate(10);

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
            'validade' => 'nullable|date',
            'observacao' => 'nullable|string',
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
        $request->validate([
            'status' => 'required|in:Ativo,Expirado,Bloqueado,Devolvido',
            'observacao' => 'nullable|string',
            'validade' => 'nullable|date',
        ]);

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
