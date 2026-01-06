<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EstadoProcesso;
use App\Models\Aditamento;
use App\Models\HistoricoProcesso;
use App\Models\Oficio;



class Processo extends Model
{
        public function estado()
        {
                return $this->belongsTo(EstadoProcesso::class);
        }

        public function tecnica()
        {
                return $this->belongsTo(User::class, 'tecnica_id');
        }

        public function aditamentos()
        {
                return $this->hasMany(Aditamento::class);
        }

        public function historico()
        {
                return $this->hasMany(HistoricoProcesso::class);
        }

        public function oficios()
        {
                return $this->hasMany(Oficio::class);
        }
}
