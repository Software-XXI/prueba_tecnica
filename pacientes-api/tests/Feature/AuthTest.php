<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;
    public function test_login_exitoso_devuelve_token()
    {
        $password = '1234567890';

        $user = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'admin@admin.com',
            'password' => $password,
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'access_token',
                     'token_type',
                     'expires_in',
                 ]);
    }

        public function test_login_falla_con_password_incorrecta()
    {
        $user = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('correcta123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'admin@admin.com',
            'password' => 'incorrecta',
        ]);

        $response->assertStatus(401);
    }
}