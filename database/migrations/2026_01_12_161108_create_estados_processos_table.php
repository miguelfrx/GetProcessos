<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('estados_processos', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // em Apreciação, Concluído, etc.
            $table->string('cor')->default('#3b82f6');
            $table->timestamps();
        });
    }
};
