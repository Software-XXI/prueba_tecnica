<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Departamento; 
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departamento::insert([
        ['nombre' => 'Antioquia'],
        ['nombre' => 'Cundinamarca'],
        ['nombre' => 'Valle del Cauca'],
        ['nombre' => 'Atlántico'],
        ['nombre' => 'Santander'],
    ]);
    }
}
