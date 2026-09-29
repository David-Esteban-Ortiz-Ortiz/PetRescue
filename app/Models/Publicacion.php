<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';

    protected $fillable = [
        'codigo_publicacion',
        'nombre_autor',
        'titulo',
        'tipo_publicacion',
        'contenido',
        'fotografia',
        'estado',
        'fecha_publicacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_publicacion' => 'datetime',
        ];
    }

    public const TIPOS = [
        'Consejo',
        'Historia',
        'Experiencia',
        'Actividad',
        'Informacion',
    ];

    public const ESTADOS = [
        'Pendiente',
        'Visible',
        'Oculta',
    ];
}
