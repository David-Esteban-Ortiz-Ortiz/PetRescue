<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->quitarForeignKeySiExiste('mascotas', 'propietario_id');
        $this->quitarForeignKeySiExiste('reportes', 'usuario_reportante_id');

        Schema::table('mascotas', function (Blueprint $table) {
            $table->unsignedBigInteger('propietario_id')->nullable()->change();
        });

        Schema::table('reportes', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_reportante_id')->nullable()->change();
        });

        Schema::table('reportes', function (Blueprint $table) {
            $table->string('nombre_contacto', 150)->nullable()->after('usuario_reportante_id');
            $table->string('telefono_contacto', 20)->nullable()->after('nombre_contacto');
            $table->string('correo_contacto', 150)->nullable()->after('telefono_contacto');
            $table->string('medio_contacto_preferido', 20)->nullable()->after('correo_contacto');
            $table->string('codigo_reporte', 30)->nullable()->unique()->after('medio_contacto_preferido');
            $table->string('codigo_edicion', 255)->nullable()->after('codigo_reporte');
        });
    }

    public function down(): void
    {
        Schema::table('reportes', function (Blueprint $table) {
            $table->dropColumn([
                'nombre_contacto',
                'telefono_contacto',
                'correo_contacto',
                'medio_contacto_preferido',
                'codigo_reporte',
                'codigo_edicion',
            ]);
        });
    }

    private function quitarForeignKeySiExiste(string $tabla, string $columna): void
    {
        try {
            Schema::table($tabla, function (Blueprint $table) use ($columna) {
                $table->dropForeign([$columna]);
            });
        } catch (\Throwable $e) {
            // La llave foránea no existía, continuar
        }
    }
};
