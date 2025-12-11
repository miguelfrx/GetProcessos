<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'email', 'contato', 'estado_id', 'numcadastro', 'data_entrada'
    ];

    public function anexos()
    {
        return $this->hasMany(AnexoCadastro::class, 'idcadastro');
    }
    
    public function estado()
    {
        return $this->belongsTo(EstadoCadastro::class, 'estado_id');
    }
}
