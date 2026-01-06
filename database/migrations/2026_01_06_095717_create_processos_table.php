<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('processos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_processo');
            $table->string('origem');
            $table->string('requerente');

            // Em vez de foreignId, use string para testar sem erro:
            $table->string('tecnica_nome')->nullable();
            $table->string('estado_descricao')->nullable();

            $table->timestamps();
        });
    }
};
