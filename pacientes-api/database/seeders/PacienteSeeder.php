<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Paciente;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Paciente::insert([
          [
              'tipo_documento_id' => 1,
              'numero_documento' => '1001',
              'nombre1' => 'Juan',
              'nombre2' => null,
              'apellido1' => 'Perez',
              'apellido2' => 'Lopez',
              'genero_id' => 1,
              'departamento_id' => 1,
              'municipio_id' => 1,
              'correo' => 'juan@test.com',
          ],
          [
              'tipo_documento_id' => 1,
              'numero_documento' => '1002',
              'nombre1' => 'Ana',
              'nombre2' => null,
              'apellido1' => 'Gomez',
              'apellido2' => 'Diaz',
              'genero_id' => 2,
              'departamento_id' => 2,
              'municipio_id' => 3,
              'correo' => 'ana@test.com',
          ],
          [
              'tipo_documento_id' => 2,
              'numero_documento' => '1003',
              'nombre1' => 'Luis',
              'nombre2' => null,
              'apellido1' => 'Martinez',
              'apellido2' => 'Rios',
              'genero_id' => 1,
              'departamento_id' => 3,
              'municipio_id' => 5,
              'correo' => 'luis@test.com',
          ],
          [
              'tipo_documento_id' => 1,
              'numero_documento' => '1004',
              'nombre1' => 'Laura',
              'nombre2' => null,
              'apellido1' => 'Torres',
              'apellido2' => 'Vega',
              'genero_id' => 2,
              'departamento_id' => 4,
              'municipio_id' => 7,
              'correo' => 'laura@test.com',
          ],
          [
              'tipo_documento_id' => 1,
              'numero_documento' => '1005',
              'nombre1' => 'Pedro',
              'nombre2' => null,
              'apellido1' => 'Ramirez',
              'apellido2' => 'Castro',
              'genero_id' => 1,
              'departamento_id' => 5,
              'municipio_id' => 9,
              'correo' => 'pedro@test.com',
          ],
        ]);
    }
}
