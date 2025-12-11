<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnexoCadastro extends Model
{
    use HasFactory;

    protected $table = 'anexos_cadastros';

    protected $fillable = [
        'idcadastro', 'ficheiro', 'caminho', 'data_entrada', 'tipo'
    ];

    public function cadastro()
    {
        return $this->belongsTo(Cadastro::class, 'idcadastro');
    }
}
