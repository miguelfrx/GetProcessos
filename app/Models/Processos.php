<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Processos extends Model
{
    use HasFactory;

    /**
     * Campos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'numero_cme',
        'numero_eamb',
        'requerente',
        'nif',
        'morada_localizacao',
        'data_entrada',
        'tecnica_id',
        'estado_id',
        'observacoes'
    ];

    /**
     * Relação com o Estado (Ex: Aguardando, em Apreciação)
     */
    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoProcesso::class, 'estado_id');
    }


    public function tecnica(): BelongsTo
    {
        return $this->belongsTo(Tecnicas::class, 'tecnica_id');
    }


    public function aditamentos(): HasMany
    {
        return $this->hasMany(Aditamento::class, 'processo_id');
    }


    public function despachos(): HasMany
    {
        return $this->hasMany(Despachos::class, 'processo_id');
    }
}
