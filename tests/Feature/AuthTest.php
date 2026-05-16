<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        Role::create([
            'name' => 'Admin'
        ]);

        $response = $this->postJson('/api/register', [
            'name' => 'Juan Perez',
            'email' => 'juan@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role_id' => 1
        ]);

        $response->assertStatus(201);
    }

    public function test_user_can_login()
    {
        Role::create([
            'name' => 'Admin'
        ]);

        $this->postJson('/api/register', [
            'name' => 'Juan Perez',
            'email' => 'juan@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role_id' => 1
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'juan@example.com',
            'password' => '12345678'
        ]);

        $response->assertStatus(200);
    }
}