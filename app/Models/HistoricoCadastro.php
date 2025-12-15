<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoCadastro extends Model
{
    use HasFactory;

    protected $table = 'historico_cadastros';

    protected $fillable = [
        'cadastro_id',
        'data_hora',
        'id_user',
        'id_tecnico',
        'estado_anterior_id',
        'estado_atual_id'
    ];

    public $timestamps = false; // já tens data_hora manual

    // Relação com o cadastro
    public function cadastro()
    {
        return $this->belongsTo(Cadastro::class, 'cadastro_id');
    }

    // Estado anterior
    public function estadoAnterior()
    {
        return $this->belongsTo(EstadoCadastro::class, 'estado_anterior_id');
    }

    // Estado atual
    public function estadoAtual()
    {
        return $this->belongsTo(EstadoCadastro::class, 'estado_atual_id');
    }
}
