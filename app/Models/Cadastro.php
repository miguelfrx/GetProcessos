<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'email', 'contato', 'estado_id', 'numcadastro', 'data_entrada',
        'nomeFaturacao', 'nifFaturacao', 'moradaFaturacao', 'codigoPostalFaturacao', 'localidadeFaturacao', 'id_tecnico'
    ];

    // Relação com anexos
    public function anexos()
    {
        return $this->hasMany(AnexoCadastro::class, 'idcadastro');
    }

    // Relação com estado atual
    public function estado()
    {
        return $this->belongsTo(EstadoCadastro::class, 'estado_id');
    }

    // Relação com histórico de estados
    public function historico()
    {
        return $this->hasMany(HistoricoCadastro::class, 'cadastro_id');
    }

    // Função helper para obter o estado anterior
    public function estadoAnterior()
    {
        $ultimoHistorico = $this->historico()->latest('data_hora')->first();
        return $ultimoHistorico ? $ultimoHistorico->estado_anterior : null;
    }
}
