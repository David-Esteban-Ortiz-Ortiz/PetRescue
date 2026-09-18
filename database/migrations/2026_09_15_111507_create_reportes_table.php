<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mascota_id')
                ->constrained('mascotas')
                ->cascadeOnDelete();

            $table->foreignId('usuario_reportante_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->enum('tipo_reporte', [
                'Perdida',
                'Hallazgo'
            ]);

            $table->date('fecha_suceso');

            $table->time('hora_aproximada')->nullable();

            $table->string('ciudad', 100);

            $table->string('barrio', 150);

            $table->string('direccion_referencia', 255);

            $table->text('descripcion');

            $table->string('ubicacion_actual', 255)->nullable();

            $table->enum('estado_fisico', [
                'Bueno',
                'Herido',
                'Requiere atencion',
                'No identificado'
            ])->nullable();

            $table->enum('estado', [
                'Activo',
                'Resuelto',
                'Cancelado'
            ])->default('Activo');

            $table->timestamp('fecha_publicacion')->useCurrent();

            $table->timestamp('fecha_cierre')->nullable();

            $table->timestamps();

            $table->index('tipo_reporte');
            $table->index('estado');
            $table->index('ciudad');
            $table->index('barrio');
            $table->index('fecha_suceso');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
