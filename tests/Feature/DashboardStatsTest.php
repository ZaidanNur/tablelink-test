<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DashboardStatsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected string $adminToken;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        Role::create(['name' => 'User', 'guard_name' => 'web']);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('Admin');
        $this->adminToken = $this->admin->createToken('test-token')->plainTextToken;
    }

    /** @test */
    public function admin_can_get_dashboard_stats(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->getJson('/api/dashboard/stats');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Dashboard statistics retrieved successfully',
            ]);
    }

    /** @test */
    public function stats_returns_correct_structure(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->getJson('/api/dashboard/stats');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'line_chart' => [
                        'labels',
                        'datasets',
                    ],
                    'bar_chart' => [
                        'labels',
                        'datasets',
                    ],
                    'pie_chart' => [
                        'labels',
                        'datasets',
                    ],
                    'summary' => [
                        'total_users',
                        'active_today',
                        'new_this_month',
                    ],
                ],
            ]);
    }

    /** @test */
    public function line_chart_has_12_months_data(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->getJson('/api/dashboard/stats');

        $response->assertStatus(200);

        $data = $response->json('data.line_chart');
        $this->assertCount(12, $data['labels']);
        $this->assertCount(12, $data['datasets'][0]['data']);
    }

    /** @test */
    public function bar_chart_has_7_days_data(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->getJson('/api/dashboard/stats');

        $response->assertStatus(200);

        $data = $response->json('data.bar_chart');
        $this->assertCount(7, $data['labels']);
        $this->assertCount(7, $data['datasets'][0]['data']);
    }

    /** @test */
    public function pie_chart_has_role_distribution(): void
    {
        $adminUser = User::factory()->create();
        $adminUser->assignRole('Admin');
        
        $regularUsers = User::factory()->count(3)->create();
        foreach ($regularUsers as $user) {
            $user->assignRole('User');
        }

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->getJson('/api/dashboard/stats');

        $response->assertStatus(200);

        $data = $response->json('data.pie_chart');
        $this->assertContains('Admin', $data['labels']);
        $this->assertContains('User', $data['labels']);
    }

    /** @test */
    public function summary_counts_are_accurate(): void
    {
        User::factory()->count(5)->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->adminToken)
            ->getJson('/api/dashboard/stats');

        $response->assertStatus(200);

        $summary = $response->json('data.summary');
        // 1 admin + 5 factory users = 6 total
        $this->assertEquals(6, $summary['total_users']);
    }
}
