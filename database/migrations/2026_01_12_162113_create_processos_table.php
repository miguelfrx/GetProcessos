<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('processos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cme')->nullable();
            $table->string('numero_eamb')->unique();
            $table->string('requerente');

            // ESTES SÃO OS CAMPOS QUE ESTAVAM A FALTAR:
            $table->date('data_entrada')->nullable(); // Data em que o processo entrou
            $table->dateTime('data_registo_eamb')->useCurrent(); // Data/Hora do registo no teu sistema

            $table->foreignId('tecnica_id')->nullable()->constrained('tecnicas');
            $table->foreignId('estado_id')->constrained('estados_processos');

            $table->timestamps();
        });
    }
};
