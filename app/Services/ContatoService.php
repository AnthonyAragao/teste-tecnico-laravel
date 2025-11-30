<?php

namespace App\Services;

use App\Contracts\ContatoRepositoryInterface;
use App\Contracts\ExternalApiServiceInterface;
use App\Models\Contato;
use Illuminate\Database\Eloquent\Collection;

class ContatoService
{
    public function __construct(
        private ContatoRepositoryInterface $contatoRepository,
        private ExternalApiServiceInterface $externalApiService
    ) {}

    public function findById($id): ?Contato
    {
        return $this->contatoRepository->findById((int) $id);
    }

    public function create(array $data): Contato
    {
        return $this->contatoRepository->create($data);
    }

    public function update($id, array $data): bool
    {
        return $this->contatoRepository->update((int) $id, $data);
    }

    public function delete($id): bool
    {
        return $this->contatoRepository->delete((int) $id);
    }

    public function getByPessoa($pessoaId): Collection
    {
        return $this->contatoRepository->getByPessoa((int) $pessoaId);
    }

    public function getCountByCountry(): array
    {
        $contatos = $this->contatoRepository->getCountByCountry();
        $countries = collect($this->externalApiService->getCountries())->keyBy('calling_code');
        
        return $contatos->map(function ($contato) use ($countries) {
            $country = $countries->get($contato->country_code);
            return [
                'country_name' => $country['name'] ?? 'Unknown',
                'country_code' => $contato->country_code,
                'total' => $contato->total
            ];
        })->toArray();
    }

    public function getCountries(): array
    {
        return $this->externalApiService->getCountries();
    }
}