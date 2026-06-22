<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserDashboardTest extends TestCase
{
    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_dashboard(): void
    {
        $user = User::factory()->make([
            'id' => 999999,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Tổng quan tài khoản');
        $response->assertSee($user->name);
    }
}
