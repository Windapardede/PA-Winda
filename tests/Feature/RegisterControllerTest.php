<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_data()
    {
        Mail::fake();

        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/register', $userData);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Registrasi berhasil!']);

        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
            'name' => 'John Doe',
            'role' => 'user',
        ]);

        $user = User::where('email', 'john.doe@example.com')->first();

        $this->assertNotNull($user->otp);
        $this->assertMatchesRegularExpression('/^\d{6}$/', $user->otp);

        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_cannot_register_with_existing_email()
    {
        User::factory()->create([
            'email' => 'john.doe@example.com'
        ]);

        $userData = [
            'name' => 'Jane Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/register', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    public function test_cannot_register_with_invalid_data()
    {
        $userData = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => '123',
            'password_confirmation' => '1234',
        ];

        $response = $this->postJson('/register', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }

    public function test_cannot_register_with_unmatched_password_confirmation()
    {
        $userData = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'wrongpassword',
        ];

        $response = $this->postJson('/register', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
    }

    public function test_user_can_verify_valid_otp()
    {
        $user = User::factory()->create([
            'email' => 'valid@example.com',
            'otp' => '123456',
            'status_otp' => 1,
        ]);

        $response = $this->post('/create_new_account/verifikasi', [
            'email' => 'valid@example.com',
            'otp' => ['1', '2', '3', '4', '5', '6']
        ]);

        $response->assertRedirect(route('berhasildaftar.index'));

        $this->assertAuthenticatedAs($user);

        $this->assertDatabaseHas('users', [
            'email' => 'valid@example.com',
            'status_otp' => 2,
        ]);
    }

    public function test_user_cannot_verify_invalid_otp()
    {
        User::factory()->create([
            'email' => 'invalid@example.com',
            'otp' => '654321',
            'status_otp' => 1,
        ]);

        $response = $this->from('/otp')->post('/create_new_account/verifikasi', [
            'email' => 'invalid@example.com',
            'otp' => ['1', '2', '3', '4', '5', '6']
        ]);

        $response->assertRedirect('/otp');
        $response->assertSessionHas('error', 'Kode OTP salah atau sudah digunakan!');
    }
}
