<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CadastrosSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $estados = [1,2,3]; // IDs da tabela estados_cadastros

        for ($i = 0; $i < 20; $i++) {
            DB::table('cadastros')->insert([
                'nome' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'contato' => $faker->numberBetween(910000000, 969999999),
                'data_entrada' => $faker->dateTimeThisYear,
                'id_tecnico' => $faker->numberBetween(1,5),
                'estado_id' => $faker->randomElement($estados),
                'numcadastro' => strtoupper($faker->bothify('CAD-####')),
                'nomeFaturacao' => $faker->company,
                'nifFaturacao' => $faker->numberBetween(100000000, 999999999),
                'moradaFaturacao' => $faker->streetAddress,
                'codigoPostalFaturacao' => $faker->postcode,
                'localidadeFaturacao' => $faker->city,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
