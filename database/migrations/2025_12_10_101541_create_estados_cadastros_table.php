<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Cria a tabela apenas se não existir
        if (!Schema::hasTable('estados_cadastros')) {
            Schema::create('estados_cadastros', function (Blueprint $table) {
                $table->id();
                $table->string('descricao');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('estados_cadastros');
    }
};
