<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnexoCadastro;
use App\Models\Cadastro;
use Carbon\Carbon;

class AnexoCadastroSeeder extends Seeder
{
    public function run()
    {
        $cadastros = Cadastro::all();

        foreach ($cadastros as $cadastro) {
            // Criar entre 1 e 3 anexos por cadastro
            $numAnexos = rand(1, 3);
            for ($i = 1; $i <= $numAnexos; $i++) {
                AnexoCadastro::create([
                    'idcadastro' => $cadastro->id,
                    'ficheiro' => "ficheiro_$i.pdf",
                    'caminho' => "/uploads/cadastro_{$cadastro->id}/ficheiro_$i.pdf",
                    'data_entrada' => Carbon::now()->subDays(rand(0, 30)),
                    'tipo' => "documento",
                ]);
            }
        }
    }
}
