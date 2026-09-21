<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reporte extends Model
{
    use HasFactory;

    protected $table = 'reportes';

    protected $fillable = [
        'mascota_id',
        'usuario_reportante_id',
        'nombre_contacto',
        'telefono_contacto',
        'correo_contacto',
        'medio_contacto_preferido',
        'codigo_reporte',
        'codigo_edicion',
        'tipo_reporte',
        'fecha_suceso',
        'hora_aproximada',
        'ciudad',
        'barrio',
        'direccion_referencia',
        'descripcion',
        'ubicacion_actual',
        'estado_fisico',
        'estado',
        'fecha_publicacion',
        'fecha_cierre',
    ];

    protected $hidden = [
        'codigo_edicion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_suceso' => 'date',
            'fecha_publicacion' => 'datetime',
            'fecha_cierre' => 'datetime',
        ];
    }

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(
            Mascota::class,
            'mascota_id'
        );
    }

    public function usuarioReportante(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'usuario_reportante_id'
        );
    }
}
