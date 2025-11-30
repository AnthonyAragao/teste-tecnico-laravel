<?php

namespace App\Contracts;

use App\Models\Contato;
use Illuminate\Database\Eloquent\Collection;

interface ContatoRepositoryInterface
{
    public function findById(int $id): ?Contato;
    public function create(array $data): Contato;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getByPessoa(int $pessoaId): Collection;
    public function getCountByCountry(): Collection;
}