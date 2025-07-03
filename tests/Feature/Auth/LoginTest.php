<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_dapat_login_dengan_credential_yang_benar()
    {
        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($admin);
    }

    /** @test */
    public function hrd_dapat_login_dengan_credential_yang_benar()
    {
        $hrd = User::create([
            'name' => 'HRD Test',
            'email' => 'hrd@example.com',
            'password' => Hash::make('hrd123'),
            'role' => 'hrd',
        ]);

        $response = $this->post('/login', [
            'email' => 'hrd@example.com',
            'password' => 'hrd123',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($hrd);
    }

    /** @test */
    public function mentor_dapat_login_dengan_credential_yang_benar()
    {
        $mentor = User::create([
            'name' => 'Mentor Test',
            'email' => 'mentor@example.com',
            'password' => Hash::make('mentor123'),
            'role' => 'mentor',
        ]);

        $response = $this->post('/login', [
            'email' => 'mentor@example.com',
            'password' => 'mentor123',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($mentor);
    }

    /** @test */
    public function user_biasa_dapat_login_dan_diarahkan_ke_posisi()
    {
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => 'user123',
        ]);

        $response->assertRedirect('/posisi');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function login_gagal_dengan_password_salah()
    {
        User::create([
            'name' => 'Gagal Test',
            'email' => 'fail@example.com',
            'password' => Hash::make('benar123'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'fail@example.com',
            'password' => 'salahbanget',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
