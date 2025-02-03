<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartao extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_granja',
        'cidade',
        'tecnico',
        'pin',
        'puk',
        'validade',
        'status',
    ];
}
