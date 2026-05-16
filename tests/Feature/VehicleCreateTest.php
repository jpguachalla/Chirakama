<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_vehicle()
    {
        Role::create([
            'name' => 'Admin'
        ]);

        $category = Category::create([
            'name' => 'SUV'
        ]);

        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345678'),
            'role_id' => 1
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/vehicles', [
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2024,
            'price' => 25000,
            'stock' => 5,
            'category_id' => $category->id
        ]);

        $response->assertStatus(201);
    }
}