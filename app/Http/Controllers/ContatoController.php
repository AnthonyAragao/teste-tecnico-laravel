<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContatoRequest;
use App\Services\ContatoService;
use App\Services\PessoaService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContatoController extends Controller
{
    public function __construct(
        private ContatoService $contatoService,
        private PessoaService $pessoaService
    ) {}

    public function create(Request $request): Response
    {
        $pessoaId = $request->get('pessoa_id');
        $pessoa = null;
        
        if ($pessoaId) {
            $pessoa = $this->pessoaService->findById($pessoaId);
        }
        
        return Inertia::render('Contatos/Create', [
            'pessoa' => $pessoa,
            'countries' => $this->contatoService->getCountries()
        ]);
    }

    public function store(StoreContatoRequest $request): RedirectResponse
    {
        $contato = $this->contatoService->create($request->validated());
        
        return redirect()->route('pessoas.show', $contato->pessoa_id)
            ->with('success', 'Contato criado com sucesso!');
    }

    public function show(string $id): Response
    {
        $contato = $this->contatoService->findById((int) $id);
        
        if (!$contato) {
            abort(404);
        }
        
        return Inertia::render('Contatos/Show', [
            'contato' => $contato->load('pessoa')
        ]);
    }

    public function edit(string $id): Response
    {
        $contato = $this->contatoService->findById((int) $id);
        
        if (!$contato) {
            abort(404);
        }
        
        return Inertia::render('Contatos/Edit', [
            'contato' => $contato->load('pessoa'),
            'countries' => $this->contatoService->getCountries()
        ]);
    }

    public function update(StoreContatoRequest $request, string $id): RedirectResponse
    {
        $updated = $this->contatoService->update((int) $id, $request->validated());
        
        if (!$updated) {
            return back()->with('error', 'Erro ao atualizar contato.');
        }
        
        $contato = $this->contatoService->findById($id);
        
        return redirect()->route('pessoas.show', $contato->pessoa_id)
            ->with('success', 'Contato atualizado com sucesso!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $contato = $this->contatoService->findById((int) $id);
        $pessoaId = $contato->pessoa_id;
        
        $deleted = $this->contatoService->delete((int) $id);
        
        if (!$deleted) {
            return back()->with('error', 'Erro ao excluir contato.');
        }
        
        return redirect()->route('pessoas.show', $pessoaId)
            ->with('success', 'Contato excluído com sucesso!');
    }
}
