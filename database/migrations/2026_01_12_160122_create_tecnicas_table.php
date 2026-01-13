<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tecnicas', function (Blueprint $table) {
            $table->id(); // Este será o ID da técnica usado na distribuição
            $table->string('nome');
            $table->string('email')->unique();
            $table->boolean('ativa')->default(true); // Para o caso de uma técnica estar de férias
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tecnicas');
    }
};
