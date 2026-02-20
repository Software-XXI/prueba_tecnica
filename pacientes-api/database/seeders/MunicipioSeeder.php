<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Municipio; 

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Municipio::insert([
        ['departamento_id' => 1, 'nombre' => 'Medellín'],
        ['departamento_id' => 1, 'nombre' => 'Envigado'],

        ['departamento_id' => 2, 'nombre' => 'Bogotá'],
        ['departamento_id' => 2, 'nombre' => 'Soacha'],

        ['departamento_id' => 3, 'nombre' => 'Cali'],
        ['departamento_id' => 3, 'nombre' => 'Palmira'],

        ['departamento_id' => 4, 'nombre' => 'Barranquilla'],
        ['departamento_id' => 4, 'nombre' => 'Soledad'],

        ['departamento_id' => 5, 'nombre' => 'Bucaramanga'],
        ['departamento_id' => 5, 'nombre' => 'Floridablanca'],
        ]);
    }
}
