<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_shows_current_user_profile_and_login_status(): void
    {
        $user = User::factory()->create([
            'name' => 'Rizki Admin',
            'email' => 'rizki@example.com',
            'role' => 'admin',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Rizki Admin');
        $response->assertSee('Sedang Login');
        $response->assertSee('Administrator');
    }
}
