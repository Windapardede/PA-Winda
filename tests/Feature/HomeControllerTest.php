<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_user_is_redirected_to_admin_dashboard()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/home');

        $response->assertStatus(200);
        $response->assertViewIs('pages.dashboard');
    }

    /** @test */
    public function hrd_user_is_redirected_to_hrd_dashboard()
    {
        $hrd = User::create([
            'name' => 'HRD User',
            'email' => 'hrd@example.com',
            'password' => Hash::make('password'),
            'role' => 'hrd',
        ]);

        $response = $this->actingAs($hrd)->get('/home');

        $response->assertStatus(200);
        $response->assertViewIs('pages.dashboard');
    }

    /** @test */
    public function mentor_user_is_redirected_to_mentor_dashboard()
    {
        $mentor = User::create([
            'name' => 'Mentor User',
            'email' => 'mentor@example.com',
            'password' => Hash::make('password'),
            'role' => 'mentor',
        ]);

        $response = $this->actingAs($mentor)->get('/home');

        $response->assertStatus(200);
        $response->assertViewIs('pages.mentor.dashboard');
    }

    /** @test */
    public function guest_is_redirected_to_login()
    {
        $response = $this->get('/home');

        $response->assertRedirect('/login');
    }
}
