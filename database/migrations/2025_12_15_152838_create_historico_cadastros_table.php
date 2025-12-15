<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historico_cadastros', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cadastro_id'); // referência para cadastro
            $table->unsignedBigInteger('estado_anterior_id')->nullable(); // estado anterior
            $table->unsignedBigInteger('estado_atual_id'); // estado atual
            $table->unsignedBigInteger('id_user')->nullable(); // utilizador que alterou
            $table->unsignedBigInteger('id_tecnico')->nullable(); // técnico responsável
            $table->dateTime('data_hora')->default(now());

            $table->timestamps();

            // Chaves estrangeiras
            $table->foreign('cadastro_id')
                  ->references('id')->on('cadastros')
                  ->onDelete('cascade');

            $table->foreign('estado_anterior_id')
                  ->references('id')->on('estados_cadastros')
                  ->onDelete('set null');

            $table->foreign('estado_atual_id')
                  ->references('id')->on('estados_cadastros')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historico_cadastros');
    }
};
