<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('propietario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('nombre', 100)->nullable();

            $table->enum('tipo', [
                'Perro',
                'Gato',
                'Otro'
            ]);

            $table->string('raza', 100)->nullable();

            $table->string('color_principal', 100);

            $table->string('color_secundario', 100)->nullable();

            $table->enum('tamano', [
                'Pequeno',
                'Mediano',
                'Grande'
            ]);

            $table->enum('sexo', [
                'Macho',
                'Hembra',
                'Desconocido'
            ])->default('Desconocido');

            $table->string('edad_aproximada', 50)->nullable();

            $table->text('caracteristicas_particulares');

            $table->string('identificacion', 150)->nullable();

            $table->string('fotografia', 255)->nullable();

            $table->timestamps();

            $table->index('tipo');
            $table->index('nombre');
            $table->index('color_principal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
