<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aditamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'processo_id',
        'tecnica_id',
        'descricao',
        'estado_atual'
    ];

    /**
     * Relaciona o aditamento com o processo pai
     */
    public function processo(): BelongsTo
    {
        return $this->belongsTo(Processos::class);
    }

    /**
     * Relaciona o aditamento com a técnica que o criou
     * IMPORTANTE: Sem isto, o erro "undefined relationship [tecnica]" acontece.
     */
    public function tecnica(): BelongsTo
    {
        return $this->belongsTo(Tecnicas::class, 'tecnica_id');
    }
}
