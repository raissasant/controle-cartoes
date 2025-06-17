<?php

namespace App\Http\Controllers;

use App\Models\Permissao;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PermissaoController extends Controller
{
    /**
     * Lista todas as permissões com opção de pesquisa por e-mail
     */
    public function index(Request $request): View
    {
        $this->authorizeAdmin();

        $query = Permissao::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('email', 'like', '%' . $search . '%');
        }

        $permissoes = $query->orderBy('email')->get();

        return view('permissoes.index', compact('permissoes'));
    }

    public function create(): View
    {
        $this->authorizeAdmin();
        return view('permissoes.create');
    }

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

    public function edit(Permissao $permissao): View
    {
        $this->authorizeAdmin();
        return view('permissoes.edit', compact('permissao'));
    }

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

    public function destroy(Permissao $permissao): RedirectResponse
    {
        $this->authorizeAdmin();

        $permissao->delete();

        return redirect()->route('permissoes.index')->with('success', 'Permissão removida.');
    }

    private function authorizeAdmin(): void
    {
        if (!usuarioEhAdmin()) {
            abort(403, 'Acesso negado.');
        }
    }
}
