<?php

namespace Database\Seeders;

use App\Models\Pessoa;
use App\Models\Contato;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Criar pessoas com avatares simples
        $pessoa1 = Pessoa::create([
            'nome' => 'João Silva Santos',
            'email' => 'joao@teste.com',
            'avatar' => 'data:image/svg+xml;base64,' . base64_encode('<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="50" fill="#FF6B6B"/><circle cx="35" cy="40" r="5" fill="white"/><circle cx="65" cy="40" r="5" fill="white"/><path d="M 30 70 Q 50 85 70 70" stroke="white" stroke-width="3" fill="none"/></svg>')
        ]);

        $pessoa2 = Pessoa::create([
            'nome' => 'Maria Oliveira Costa',
            'email' => 'maria@teste.com',
            'avatar' => 'data:image/svg+xml;base64,' . base64_encode('<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="50" fill="#4ECDC4"/><circle cx="35" cy="40" r="5" fill="white"/><circle cx="65" cy="40" r="5" fill="white"/><path d="M 30 70 Q 50 85 70 70" stroke="white" stroke-width="3" fill="none"/></svg>')
        ]);

        $pessoa3 = Pessoa::create([
            'nome' => 'Pedro Santos Lima',
            'email' => 'pedro@teste.com',
            'avatar' => 'data:image/svg+xml;base64,' . base64_encode('<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="50" fill="#45B7D1"/><circle cx="35" cy="40" r="5" fill="white"/><circle cx="65" cy="40" r="5" fill="white"/><path d="M 30 70 Q 50 85 70 70" stroke="white" stroke-width="3" fill="none"/></svg>')
        ]);

        // Criar contatos
        Contato::create(['pessoa_id' => $pessoa1->id, 'country_code' => '55', 'number' => '987654321']);
        Contato::create(['pessoa_id' => $pessoa1->id, 'country_code' => '351', 'number' => '912345678']);
        Contato::create(['pessoa_id' => $pessoa2->id, 'country_code' => '1', 'number' => '555123456']);
        Contato::create(['pessoa_id' => $pessoa3->id, 'country_code' => '55', 'number' => '876543210']);
        Contato::create(['pessoa_id' => $pessoa2->id, 'country_code' => '33', 'number' => '123456789']);
    }
}