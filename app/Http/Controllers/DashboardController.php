<?php

namespace App\Http\Controllers;

use App\Services\ContatoService;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(
        private ContatoService $contatoService
    ) {}

    public function index(): Response
    {
        $contatosPorPais = $this->contatoService->getCountByCountry();
        
        return Inertia::render('Dashboard/Index', [
            'contatosPorPais' => $contatosPorPais
        ]);
    }
}
