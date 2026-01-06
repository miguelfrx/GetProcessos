<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aditamento extends Model
{
    protected $table = 'aditamentos';

    protected $fillable = [
        'processo_id',
        'tipo_peca',
        'estado_id',
        'id_tecnico'
    ];
}
