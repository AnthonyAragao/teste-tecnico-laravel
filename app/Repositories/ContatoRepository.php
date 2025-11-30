<?php

namespace App\Repositories;

use App\Contracts\ContatoRepositoryInterface;
use App\Models\Contato;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ContatoRepository implements ContatoRepositoryInterface
{
    public function findById(int $id): ?Contato
    {
        return Contato::with('pessoa')->find($id);
    }

    public function create(array $data): Contato
    {
        return Contato::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return Contato::where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return Contato::destroy($id);
    }

    public function getByPessoa(int $pessoaId): Collection
    {
        return Contato::where('pessoa_id', $pessoaId)->get();
    }

    public function getCountByCountry(): Collection
    {
        return Contato::select('country_code', DB::raw('count(*) as total'))
            ->groupBy('country_code')
            ->orderBy('total', 'desc')
            ->get();
    }
}