<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
           Schema::create('todoscadastros', function (Blueprint $table) {
            $table->id(); // ID auto-increment
            $table->string('nome'); // Nome
            $table->string('email')->nullable(); // Email (pode ser nulo)
            $table->string('estado')->default('pendente'); // Estado
            $table->string('anexos')->nullable(); // Anexos (pode ser nulo)
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todoscadastros');
    }
};
