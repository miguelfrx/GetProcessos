<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aditamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('processo_id')->constrained('processos')->onDelete('cascade');
            $table->foreignId('tecnica_id')->constrained('tecnicas'); // Técnica que tratou este aditamento
            $table->text('descricao')->nullable();
            $table->string('estado_atual');
            $table->timestamps();
        });
    }
};
