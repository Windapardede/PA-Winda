<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_profile_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('profileuser.index'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.user.have_acc.profile.index');
    }

    public function test_user_can_access_create_form()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('profileuser.create'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.user.have_acc.profile.create');
    }

    public function test_store_profile_with_valid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'Test User',
            'nim' => '123456',
            'agama' => 'Islam',
            'email' => 'test@example.com',
            'phone' => '08123456789',
            'gender' => 'Laki-laki',
            'institution' => 'Politeknik Caltex Riau',
            'jurusan' => 'Teknik Informatika',
            'start_date' => '2025-07-01',
            'end_date' => '2025-07-31',
            'position' => 'Frontend Developer',
        ];

        $response = $this->post(route('profileuser.store'), $data);

        $response->assertRedirect(route('profileuser.index'));
        $response->assertSessionHas('success');
    }

    public function test_update_profile_photo_cv_surat()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $photo = UploadedFile::fake()->image('avatar.jpg');
        $cv = UploadedFile::fake()->create('cv.pdf', 200);
        $surat = UploadedFile::fake()->create('surat.pdf', 200);

        $response = $this->post(
            "/profileuser/{$user->id}/edit",
            [
                'photo' => $photo,
                'cv' => $cv,
                'surat' => $surat,
                'name' => 'Updated Name'
            ]
        );

        $response->assertRedirect(route('profileuser.index'));
        $response->assertSessionHas('success');
    }

    public function test_change_password_successfully()
    {
        $user = User::factory()->create([
            'password' => bcrypt('oldpassword')
        ]);

        $this->actingAs($user);

        $response = $this->post(route('user.update-password'), [
            'current_password' => 'oldpassword',
            'new_password' => 'newpassword',
            'new_password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status', 'Kata sandi berhasil diperbarui.');
    }

    public function test_change_password_fails_with_wrong_current()
    {
        $user = User::factory()->create([
            'password' => bcrypt('correctpassword')
        ]);

        $this->actingAs($user);

        $response = $this->post(route('user.update-password'), [
            'current_password' => 'wrongpassword',
            'new_password' => 'newpassword',
            'new_password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Kata sandi saat ini salah.');
    }
}
