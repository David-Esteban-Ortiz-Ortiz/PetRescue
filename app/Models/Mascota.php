<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mascota extends Model
{
    use HasFactory;

    protected $table = 'mascotas';

    protected $fillable = [
        'propietario_id',
        'nombre',
        'tipo',
        'raza',
        'color_principal',
        'color_secundario',
        'tamano',
        'sexo',
        'edad_aproximada',
        'caracteristicas_particulares',
        'identificacion',
        'fotografia',
    ];

    public function propietario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'propietario_id'
        );
    }

    public function reportes(): HasMany
    {
        return $this->hasMany(
            Reporte::class,
            'mascota_id'
        );
    }
}
