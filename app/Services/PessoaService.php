<?php

namespace App\Services;

use App\Contracts\PessoaRepositoryInterface;
use App\Contracts\ExternalApiServiceInterface;
use App\Models\Pessoa;
use Illuminate\Pagination\LengthAwarePaginator;

class PessoaService
{
    public function __construct(
        private PessoaRepositoryInterface $pessoaRepository,
        private ExternalApiServiceInterface $externalApiService
    ) {}

    public function getAll(): LengthAwarePaginator
    {
        return $this->pessoaRepository->getAll();
    }

    public function findById($id): ?Pessoa
    {
        return $this->pessoaRepository->findById((int) $id);
    }

    public function create(array $data): Pessoa
    {
        $data['avatar'] = $this->externalApiService->generateAvatar();
        return $this->pessoaRepository->create($data);
    }

    public function update($id, array $data): bool
    {
        return $this->pessoaRepository->update((int) $id, $data);
    }

    public function delete($id): bool
    {
        return $this->pessoaRepository->delete((int) $id);
    }
}