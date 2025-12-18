<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoCadastro extends Model
{
    use HasFactory;

    protected $table = 'estados_cadastros';

    protected $fillable = [
        'descricao'
    ];

    public $timestamps = false;
}
