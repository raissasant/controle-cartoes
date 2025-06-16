<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oficio extends Model
{
    protected $fillable = [
        'numero_oficio',
        'ano',
        'setor',
        'data_uso',
        'responsavel',
        'motivo',
    ];

    // Accessor para exibir número formatado: 01 / 2025
    public function getNumeroFormatadoAttribute()
    {
        return str_pad($this->numero_oficio, 2, '0', STR_PAD_LEFT) . ' / ' . $this->ano;
    }
}
