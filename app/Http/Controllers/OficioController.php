<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oficio;
use Illuminate\Support\Facades\Auth;

class OficioController extends Controller
{
    public function index()
    {
        $oficios = Oficio::orderBy('ano', 'desc')
                         ->orderBy('numero_oficio', 'asc')
                         ->get();

        return view('oficios.index', compact('oficios'));
    }

    public function create()
    {
        $ano = date('Y');
        $ultimoNumero = Oficio::where('ano', $ano)->max('numero_oficio') ?? 0;
        $proximoNumero = str_pad($ultimoNumero + 1, 2, '0', STR_PAD_LEFT);
        $numeroFormatado = "{$proximoNumero} / {$ano}";
        $dataAtual = date('Y-m-d');

        return view('oficios.create', compact('numeroFormatado', 'dataAtual'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'setor' => 'required|string|max:100',
            'data_uso' => 'required|date',
            'numero_oficio' => 'nullable|integer',
        ]);

        $ano = date('Y');
        $ultimoNumero = Oficio::where('ano', $ano)->max('numero_oficio') ?? 0;
        $numero = $request->input('numero_oficio') ?? ($ultimoNumero + 1);

        try {
            Oficio::create([
                'numero_oficio' => $numero,
                'ano' => $ano,
                'setor' => $request->input('setor'),
                'data_uso' => $request->input('data_uso'),
                'responsavel' => $request->input('responsavel'),
                'motivo' => $request->input('motivo'),
            ]);

            return redirect()->route('oficios.index')->with('success', 'Ofício registrado com sucesso!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['numero_oficio' => 'Já existe um ofício com esse número para o ano atual.']);
            }

            throw $e;
        }
    }

    public function edit($id)
    {
        $oficio = Oficio::findOrFail($id);
        return view('oficios.edit', compact('oficio'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'nullable|string|max:1000',
        ]);

        $oficio = Oficio::findOrFail($id);
        $oficio->update([
            'motivo' => $request->input('motivo'),
        ]);

        return redirect()->route('oficios.index')->with('success', 'Motivo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $usuariosPermitidos = [
            'raissa.adm@agroaraca.com.br',
            'ricardo.adm@agroaraca.com.br',
            'jose.adm@agroaraca.com.br',
            'raissa.adm',
            'ricardo.adm',
            'jose.adm',
        ];

        $email = Auth::user()->email;
        $username = explode('@', $email)[0];

        if (!in_array($email, $usuariosPermitidos) && !in_array($username, $usuariosPermitidos)) {
            abort(403, 'Acesso negado.');
        }

        $oficio = Oficio::findOrFail($id);
        $oficio->delete();

        return redirect()->route('oficios.index')->with('success', 'Ofício excluído com sucesso!');
    }

    public function dashboard()
    {
        $total = Oficio::count();

        $porSetor = Oficio::select('setor', \DB::raw('count(*) as total'))
                          ->groupBy('setor')
                          ->get();

        $ultimoMes = Oficio::where('created_at', '>=', now()->subDays(30))->count();

        return view('oficios.dashboard', compact('total', 'porSetor', 'ultimoMes'));
    }
}
