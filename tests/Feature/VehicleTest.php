<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_vehicles()
    {
        $role = Role::create([
            'name' => 'Admin'
        ]);

        $user = User::factory()->create([
    'name' => 'Test Admin',
    'email' => 'admin@test.com',
    'password' => bcrypt('12345678'),
    'role_id' => $role->id
]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/vehicles');

        $response->assertStatus(200);
    }
}