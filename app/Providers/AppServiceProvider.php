<?php

namespace App\Providers;

use App\Contracts\PessoaRepositoryInterface;
use App\Contracts\ContatoRepositoryInterface;
use App\Contracts\ExternalApiServiceInterface;
use App\Repositories\PessoaRepository;
use App\Repositories\ContatoRepository;
use App\Services\ExternalApiService;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PessoaRepositoryInterface::class, PessoaRepository::class);
        $this->app->bind(ContatoRepositoryInterface::class, ContatoRepository::class);
        $this->app->bind(ExternalApiServiceInterface::class, ExternalApiService::class);
    }

    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
