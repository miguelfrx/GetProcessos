<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('cadastros')) {
        Schema::create('cadastros', function (Blueprint $table) {
            $table->id();
            $table->text('nome');
            $table->text('email')->nullable();
            $table->string('contato')->nullable(); // Melhor string
            $table->dateTime('data_entrada')->nullable();
            $table->unsignedBigInteger('id_tecnico')->nullable();
            $table->unsignedBigInteger('estado_id'); // foreign key
            $table->text('numcadastro')->nullable();
            $table->string('nomeFaturacao', 255)->nullable();
            $table->string('nifFaturacao', 20)->nullable(); // string em vez de integer
            $table->string('moradaFaturacao', 255)->nullable();
            $table->string('codigoPostalFaturacao', 45)->nullable();
            $table->string('localidadeFaturacao', 50)->nullable();
            $table->timestamps();

            // Foreign key corrigida
            $table->foreign('estado_id')
                  ->references('id')
                  ->on('estados_cadastros') // nome correto da tabela
                  ->onDelete('restrict');
        });
        }
    }

    public function down()
    {
        Schema::dropIfExists('cadastros');
    }
};
