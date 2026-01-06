<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oficio extends Model
{
    protected $table = 'oficios';

    protected $fillable = [
        'processo_id',
        'numero',
        'assunto',
        'conteudo',
        'data_envio'
    ];
}
