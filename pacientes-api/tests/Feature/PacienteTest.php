<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Paciente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class PacienteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Insertar datos de catálogo necesarios para las claves foráneas
        DB::table('tipo_documentos')->insert(['id' => 1, 'nombre' => 'CC', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('generos')->insert(['id' => 1, 'nombre' => 'Masculino', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('departamentos')->insert(['id' => 1, 'nombre' => 'Antioquia', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('municipios')->insert([
            'id' => 1,
            'nombre' => 'Medellín',
            'departamento_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function test_listar_pacientes()
    {
        $user = User::factory()->create();

        // 🔥 Limpieza forzada antes de crear los 3 pacientes
        Paciente::truncate();

        Paciente::factory()->count(13)->create();

        $response = $this->actingAs($user, 'api')->getJson('/api/pacientes');

        $response->assertStatus(200)
                 ->assertJsonCount(13);
    }

    public function test_crear_paciente()
    {
        $user = User::factory()->create();

        $payload = [
            'tipo_documento_id' => 1,
            'numero_documento' => '123456',
            'nombre1' => 'Juan',
            'apellido1' => 'Pérez',
            'genero_id' => 1,
            'departamento_id' => 1,
            'municipio_id' => 1,
            'correo' => 'juan@test.com'
        ];

        $response = $this->actingAs($user, 'api')->postJson('/api/pacientes', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['correo' => 'juan@test.com']);

        $this->assertDatabaseHas('pacientes', ['correo' => 'juan@test.com']);
    }

    public function test_actualizar_paciente()
    {
        $user = User::factory()->create();
        $paciente = Paciente::factory()->create();

        // Enviar todos los campos, modificando solo nombre1
        $data = $paciente->toArray();
        $data['nombre1'] = 'NuevoNombre';

        $response = $this->actingAs($user, 'api')
            ->putJson("/api/pacientes/{$paciente->id}", $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('pacientes', [
            'id' => $paciente->id,
            'nombre1' => 'NuevoNombre'
        ]);
    }

    public function test_eliminar_paciente()
    {
        $user = User::factory()->create();
        $paciente = Paciente::factory()->create();

        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/pacientes/{$paciente->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('pacientes', ['id' => $paciente->id]);
    }
}