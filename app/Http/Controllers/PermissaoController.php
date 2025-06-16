<?php

namespace App\Http\Controllers;

use App\Models\Permissao;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PermissaoController extends Controller
{
    /**
     * Lista todas as permissões
     */
    public function index(): View
    {
        $this->authorizeAdmin();

        $permissoes = Permissao::orderBy('email')->get();
        return view('permissoes.index', compact('permissoes'));
    }

    /**
     * Exibe o formulário de criação
     */
    public function create(): View
    {
        $this->authorizeAdmin();
        return view('permissoes.create');
    }

    /**
     * Armazena nova permissão
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'email' => 'required|email',
            'tipo' => 'required|string',
        ]);

        Permissao::firstOrCreate($validated);

        return redirect()->route('permissoes.index')->with('success', 'Permissão adicionada com sucesso.');
    }

    /**
     * Exibe o formulário de edição
     */
    public function edit(Permissao $permissao): View
    {
        $this->authorizeAdmin();
        return view('permissoes.edit', compact('permissao'));
    }

    /**
     * Atualiza uma permissão existente
     */
    public function update(Request $request, Permissao $permissao): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'email' => 'required|email',
            'tipo' => 'required|string',
        ]);

        $permissao->update($validated);

        return redirect()->route('permissoes.index')->with('success', 'Permissão atualizada com sucesso.');
    }

    /**
     * Remove uma permissão
     */
    public function destroy(Permissao $permissao): RedirectResponse
    {
        $this->authorizeAdmin();

        $permissao->delete();

        return redirect()->route('permissoes.index')->with('success', 'Permissão removida.');
    }

    /**
     * Restrição de acesso para admins
     */
    private function authorizeAdmin(): void
    {
        if (!usuarioEhAdmin()) {
            abort(403, 'Acesso negado.');
        }
    }
}
