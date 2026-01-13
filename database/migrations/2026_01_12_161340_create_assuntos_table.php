<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assuntos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo'); // O campo que estava a dar erro
            $table->text('texto_padrao')->nullable(); // Texto que aparece no editor por defeito
            $table->timestamps();
        });
    }
};
