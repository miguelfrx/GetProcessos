<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoCadastro extends Model
{
    use HasFactory;

    protected $table = 'estados_cadastros'; // <-- corrigido

    protected $fillable = [
        'descricao'
    ];

    public function cadastros()
    {
        return $this->hasMany(Cadastro::class, 'estado_id');
    }
}
