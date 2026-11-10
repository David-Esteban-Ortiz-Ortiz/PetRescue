<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';

    protected $fillable = [
        'publicacion_id',
        'reporte_id',
        'user_id', // <-- AGREGADO AQUÍ
        'nombre_autor',
        'contenido',
    ];

    // Relación con la publicación
    public function publicacion(): BelongsTo
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }

    // Relación con el reporte
    public function reporte(): BelongsTo
    {
        return $this->belongsTo(Reporte::class, 'reporte_id');
    }

    // NUEVA RELACIÓN: Para saber quién escribió el comentario y sacar su foto
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
