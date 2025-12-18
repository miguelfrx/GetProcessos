<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnexoCadastro extends Model
{
    use HasFactory;

    protected $table = 'anexos_cadastros'; // ou o nome certo da tabela

    protected $fillable = [
        'idcadastro',
        'ficheiro',
        'tipo',
        'caminho',
        'data_entrada'
    ];

    public $timestamps = false;
}
