<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FlightApiTest extends TestCase
{
    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();
        
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        Role::create(['name' => 'User', 'guard_name' => 'web']);
    }

    /** @test */
    public function guest_cannot_access_flights()
    {
        $response = $this->getJson(route('api.flights'));

        $response->assertStatus(401);
    }

    /** @test */
    public function regular_user_cannot_access_flights()
    {
        $user = User::factory()->create();
        $user->assignRole('User');
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson(route('api.flights'));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_access_flights()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');
        $token = $admin->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson(route('api.flights'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'criteria',
                    'count',
                    'flights'
                ]
            ]);
    }

}
