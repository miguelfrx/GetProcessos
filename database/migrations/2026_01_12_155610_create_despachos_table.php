<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('despachos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('processo_id')->constrained('processos')->onDelete('cascade');
            $table->foreignId('tecnica_id')->constrained('tecnicas');
            $table->string('assunto_selecionado'); // Vem da tabela assuntos
            $table->longText('conteudo_pdf'); // Conteúdo editável do modelo
            $table->string('pdf_path')->nullable(); // Caminho do ficheiro gerado
            $table->boolean('enviado_externo')->default(false);
            $table->timestamps();
        });
    }
};
