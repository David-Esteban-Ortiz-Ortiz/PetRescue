<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'telefono_principal',
        'telefono_alternativo',
        'ciudad',
        'medio_contacto_preferido',
        'horario_contacto',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function mascotas(): HasMany
    {
        return $this->hasMany(
            Mascota::class,
            'propietario_id'
        );
    }

    public function reportes(): HasMany
    {
        return $this->hasMany(
            Reporte::class,
            'usuario_reportante_id'
        );
    }
}
