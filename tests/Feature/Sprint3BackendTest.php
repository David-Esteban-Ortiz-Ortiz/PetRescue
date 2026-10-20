<?php

namespace Tests\Feature;

use App\Models\Comentario;
use App\Models\Mascota;
use App\Models\Publicacion;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Sprint3BackendTest extends TestCase
{
    use RefreshDatabase;

    private function publicacion(string $titulo, string $tipo, string $contenido = 'texto'): Publicacion
    {
        return Publicacion::create([
            'codigo_publicacion' => 'PUB-' . strtoupper(substr(md5($titulo), 0, 8)),
            'nombre_autor' => 'Autor',
            'titulo' => $titulo,
            'tipo_publicacion' => $tipo,
            'contenido' => $contenido,
            'estado' => 'Visible',
            'fecha_publicacion' => now(),
        ]);
    }

    private function reporte(string $nombre, string $tipo, string $barrio, string $ciudad): Reporte
    {
        $mascota = Mascota::create([
            'nombre' => $nombre, 'tipo' => $tipo, 'color_principal' => 'Negro',
            'tamano' => 'Mediano', 'sexo' => 'Macho', 'caracteristicas_particulares' => 'x',
        ]);

        return Reporte::create([
            'mascota_id' => $mascota->id, 'codigo_reporte' => 'PR-' . strtoupper(substr(md5($nombre), 0, 8)),
            'tipo_reporte' => 'Perdida', 'fecha_suceso' => now()->toDateString(),
            'ciudad' => $ciudad, 'barrio' => $barrio, 'direccion_referencia' => 'x',
            'descripcion' => 'x', 'estado' => 'Activo', 'fecha_publicacion' => now(),
        ]);
    }

    public function test_comentario_en_publicacion_se_guarda(): void
    {
        $this->withoutVite();
        $user = User::factory()->create(['name' => 'Juliana', 'telefono_principal' => '3000000000']);
        $pub = $this->publicacion('Hola', Publicacion::TIPOS[0]);

        $this->actingAs($user)->from('/comunidad')
            ->post(route('comentarios.publicacion.guardar', $pub->id), ['contenido' => 'Buen post'])
            ->assertRedirect('/comunidad')->assertSessionHas('exito');

        $c = Comentario::first();
        $this->assertSame($pub->id, $c->publicacion_id);
        $this->assertSame($user->id, $c->user_id);
        $this->assertSame('Juliana', $c->nombre_autor);
        $this->assertSame('Hola', $c->publicacion->titulo);
    }

    public function test_comentario_en_reporte_se_guarda_y_valida(): void
    {
        $user = User::factory()->create(['telefono_principal' => '3000000000']);
        $rep = $this->reporte('Firulais', 'Perro', 'Centro', 'Pasto');

        $this->actingAs($user)->post(route('comentarios.reporte.guardar', $rep->id), ['contenido' => ''])
            ->assertSessionHasErrors('contenido');
        $this->actingAs($user)->post(route('comentarios.reporte.guardar', $rep->id), ['contenido' => str_repeat('a', 501)])
            ->assertSessionHasErrors('contenido');
        $this->actingAs($user)->post(route('comentarios.reporte.guardar', $rep->id), ['contenido' => 'Lo vi'])
            ->assertSessionHas('exito');

        $this->assertSame(1, Comentario::count());
        $this->assertSame($rep->id, Comentario::first()->reporte->id);
    }

    public function test_invitado_no_puede_comentar(): void
    {
        $pub = $this->publicacion('Hola', Publicacion::TIPOS[0]);
        $this->post(route('comentarios.publicacion.guardar', $pub->id), ['contenido' => 'x'])
            ->assertRedirect();
        $this->assertSame(0, Comentario::count());
    }

    public function test_busqueda_y_filtro_de_publicaciones(): void
    {
        $this->withoutVite();
        [$t0, $t1] = [Publicacion::TIPOS[0], Publicacion::TIPOS[1]];
        $this->publicacion('Perro perdido', $t0);
        $this->publicacion('Consejos', $t1, 'cuidar al perro');
        $this->publicacion('Gato', $t1);

        $r = $this->get('/comunidad?buscar=perro')->assertOk();
        $this->assertEqualsCanonicalizing(['Perro perdido', 'Consejos'], $r->viewData('publicaciones')->pluck('titulo')->all());

        $r = $this->get('/comunidad?tipo=' . urlencode($t1))->assertOk();
        $this->assertEqualsCanonicalizing(['Consejos', 'Gato'], $r->viewData('publicaciones')->pluck('titulo')->all());

        $r = $this->get('/comunidad?buscar=perro&tipo=' . urlencode($t1))->assertOk();
        $this->assertSame(['Consejos'], $r->viewData('publicaciones')->pluck('titulo')->all());

        $this->assertCount(3, $this->get('/comunidad')->viewData('publicaciones'));
    }

    public function test_busqueda_y_filtro_de_reportes_en_inicio(): void
    {
        $this->withoutVite();
        $this->reporte('Firulais', 'Perro', 'Centro', 'Pasto');
        $this->reporte('Michi', 'Gato', 'Obrero', 'Cali');
        $this->reporte('Rocky', 'Perro', 'Lorenzo', 'Cali');

        $nombres = fn ($r) => collect($r->viewData('reportes'))->pluck('nombre')->all();

        $this->assertEqualsCanonicalizing(['Michi', 'Rocky'], $nombres($this->get('/inicio?buscar=cali')->assertOk()));
        $this->assertSame(['Firulais'], $nombres($this->get('/inicio?buscar=centro')));
        $this->assertSame(['Michi'], $nombres($this->get('/inicio?buscar=mich')));
        $this->assertEqualsCanonicalizing(['Firulais', 'Rocky'], $nombres($this->get('/inicio?tipo=Perro')));
        $this->assertSame(['Rocky'], $nombres($this->get('/inicio?buscar=cali&tipo=Perro')));
        $this->assertCount(3, $nombres($this->get('/inicio')));
    }
}
