<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    protected $table = 'permissoes'; // <- adicione essa linha

    protected $fillable = ['email', 'tipo'];
}
