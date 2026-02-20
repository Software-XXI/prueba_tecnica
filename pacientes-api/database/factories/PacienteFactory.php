<?php

namespace Database\Factories;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition()
    {
        return [
            'tipo_documento_id' => 1,
            'numero_documento' => $this->faker->unique()->numerify('########'),
            'nombre1' => $this->faker->firstName,
            'nombre2' => null,
            'apellido1' => $this->faker->lastName,
            'apellido2' => null,
            'genero_id' => 1,
            'departamento_id' => 1,
            'municipio_id' => 1,
            'correo' => $this->faker->unique()->safeEmail,
        ];
    }
}