<?php

namespace App\Contracts;

use App\Models\Pessoa;
use Illuminate\Pagination\LengthAwarePaginator;

interface PessoaRepositoryInterface
{
    public function getAll(): LengthAwarePaginator;
    public function findById(int $id): ?Pessoa;
    public function create(array $data): Pessoa;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}