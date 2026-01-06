<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoProcesso extends Model
{
    protected $table = 'historico_processos';

    protected $fillable = [
        'processo_id',
        'estado_anterior_id',
        'estado_atual_id',
        'id_user',
        'id_tecnico',
        'data_hora'
    ];

    public $timestamps = false;
}
