<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cadastros', function (Blueprint $table) {
            $table->id();
            $table->text('nome');
            $table->text('email');
            $table->unsignedInteger('contato');
            $table->dateTime('data_entrada')->nullable();
            $table->unsignedInteger('id_tecnico');
            $table->unsignedBigInteger('estado_id'); // foreign key
            $table->text('numcadastro');
            $table->string('nomeFaturacao', 255)->nullable();
            $table->unsignedInteger('nifFaturacao')->nullable();
            $table->string('moradaFaturacao', 255)->nullable();
            $table->string('codigoPostalFaturacao', 45)->nullable();
            $table->string('localidadeFaturacao', 50)->nullable();
            $table->timestamps(); // created_at e updated_at

            // Chave estrangeira para estados
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cadastros');
    }
};
