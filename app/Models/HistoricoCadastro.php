<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoCadastro extends Model
{
    use HasFactory;

    protected $table = 'historicos_cadastros';

    protected $fillable = [
        'cadastro_id',
        'data_hora',
        'id_user',
        'id_tecnico',
        'estado_anterior_id',
        'estado_atual_id'
    ];

    public $timestamps = false; // porque já tens data_hora manual
}
