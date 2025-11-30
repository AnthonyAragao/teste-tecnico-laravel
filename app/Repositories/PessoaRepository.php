<?php

namespace App\Repositories;

use App\Contracts\PessoaRepositoryInterface;
use App\Models\Pessoa;
use Illuminate\Pagination\LengthAwarePaginator;

class PessoaRepository implements PessoaRepositoryInterface
{
    public function getAll(): LengthAwarePaginator
    {
        return Pessoa::with('contatos')->paginate(10);
    }

    public function findById(int $id): ?Pessoa
    {
        return Pessoa::with('contatos')->find($id);
    }

    public function create(array $data): Pessoa
    {
        return Pessoa::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return Pessoa::where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        $pessoa = Pessoa::find($id);
        return $pessoa ? $pessoa->delete() : false;
    }
}