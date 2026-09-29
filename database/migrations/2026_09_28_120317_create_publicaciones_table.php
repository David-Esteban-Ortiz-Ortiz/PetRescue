<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();

            $table->string('codigo_publicacion', 20)->unique();

            $table->string('nombre_autor', 150);

            $table->string('titulo', 150);

            $table->enum('tipo_publicacion', [
                'Consejo',
                'Historia',
                'Experiencia',
                'Actividad',
                'Informacion',
            ]);

            $table->text('contenido');

            $table->string('fotografia', 255)->nullable();

            $table->enum('estado', [
                'Pendiente',
                'Visible',
                'Oculta',
            ])->default('Visible');

            $table->timestamp('fecha_publicacion')->useCurrent();

            $table->timestamps();

            $table->index('tipo_publicacion');
            $table->index('estado');
            $table->index('fecha_publicacion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};
