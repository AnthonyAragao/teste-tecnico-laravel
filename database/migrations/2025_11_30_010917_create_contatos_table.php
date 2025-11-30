<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->constrained('pessoas')->onDelete('cascade');
            $table->string('country_code', 10);
            $table->string('number', 15);
            $table->timestamps();
            
            $table->unique(['country_code', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contatos');
    }
};
