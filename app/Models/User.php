<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'setor',
    ];

    /**
     * Os atributos que devem ser ocultos em arrays/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relacionamento com os logs do usuário.
     */
    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}

/**<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password'];

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
*/
