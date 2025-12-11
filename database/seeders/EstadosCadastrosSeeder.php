<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstadosCadastrosSeeder extends Seeder
{
    public function run()
    {
        $estados = [
            [
                'descricao' => 'Submetido',
                'obs' => 'Pode ir para: Aguarda pagamento, Para Correção'
            ],
            [
                'descricao' => 'Para Correção',
                'obs' => 'Pode voltar para: Submetido'
            ],
            [
                'descricao' => 'Aguarda pagamento',
                'obs' => 'Pode ir para: Pagamento efetuado'
            ],
            [
                'descricao' => 'Pagamento efetuado',
                'obs' => 'Pode ir para: Concluído'
            ],
            [
                'descricao' => 'Concluído',
                'obs' => 'Estado final'
            ],
        ];

        foreach ($estados as $estado) {
            DB::table('estados_cadastros')->updateOrInsert(
                ['descricao' => $estado['descricao']],
                [
                    'obs' => $estado['obs'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );
        }
    }
}
