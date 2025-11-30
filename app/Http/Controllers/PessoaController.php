<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePessoaRequest;
use App\Http\Requests\UpdatePessoaRequest;
use App\Services\PessoaService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class PessoaController extends Controller
{
    public function __construct(
        private PessoaService $pessoaService
    ) {}

    public function index(): Response
    {
        $pessoas = $this->pessoaService->getAll();

        return Inertia::render('Pessoas/Index', [
            'pessoas' => $pessoas
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Pessoas/Create');
    }

    public function store(StorePessoaRequest $request): RedirectResponse
    {
        $this->pessoaService->create($request->validated());

        return redirect()->route('pessoas.index')
            ->with('success', 'Pessoa criada com sucesso!');
    }

    public function show($id): Response
    {
        $pessoa = $this->pessoaService->findById($id);

        if (!$pessoa) {
            abort(404);
        }

        return Inertia::render('Pessoas/Show', [
            'pessoa' => $pessoa->load('contatos')
        ]);
    }

    public function edit($id): Response
    {
        $pessoa = $this->pessoaService->findById($id);

        if (!$pessoa) {
            abort(404);
        }

        return Inertia::render('Pessoas/Edit', [
            'pessoa' => $pessoa
        ]);
    }

    public function update(UpdatePessoaRequest $request, $id): RedirectResponse
    {
        $updated = $this->pessoaService->update($id, $request->validated());

        if (!$updated) {
            return back()->with('error', 'Erro ao atualizar pessoa.');
        }

        return redirect()->route('pessoas.show', $id)
            ->with('success', 'Pessoa atualizada com sucesso!');
    }

    public function destroy($id): RedirectResponse
    {
        $deleted = $this->pessoaService->delete($id);

        if (!$deleted) {
            return back()->with('error', 'Erro ao excluir pessoa.');
        }

        return redirect()->route('pessoas.index')
            ->with('success', 'Pessoa excluída com sucesso!');
    }
}
