<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Mentor;

class KelolaMentorControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function bisa_menyimpan_mentor_baru()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->post('/kelolamentor', [
            'nama' => 'Mentor Baru',
            'email' => 'mentorbaru@example.com',
            'password' => 'password123',
            'posisi_mentor' => 'Programmer'
        ]);

        $response->assertStatus(302); // redirect setelah sukses simpan

        $this->assertDatabaseHas('mentors', [
            'nama' => 'Mentor Baru',
            'email' => 'mentorbaru@example.com',
            'posisi_mentor' => 'Programmer',
            'is_active' => 1,
        ]);
    }

    /** @test */
    public function bisa_mengubah_status_mentor()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $mentor = Mentor::create([
            'nama' => 'Mentor Aktif',
            'email' => 'aktif@example.com',
            'password' => bcrypt('secret'),
            'posisi_mentor' => 'Designer',
            'is_active' => 1,
        ]);

        $response = $this->put("/kelolamentor/{$mentor->id}", [
            'status' => 'tidak aktif'
        ]);

        $response->assertStatus(302); // redirect setelah update

        $this->assertDatabaseHas('mentors', [
            'id' => $mentor->id,
            'is_active' => 0,
        ]);
    }

    /** @test */
    public function bisa_menambahkan_mentee_ke_mentor()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $mentor = Mentor::create([
            'nama' => 'Mentor A',
            'email' => 'mentora@example.com',
            'password' => bcrypt('secret'),
            'posisi_mentor' => 'Backend Developer',
            'is_active' => 1,
        ]);

        $mentee = User::create([
            'name' => 'Mentee A',
            'email' => 'menteea@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $response = $this->postJson("/kelolamentor/{$mentor->id}/mentee", [
            'mentee_id' => $mentee->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => "Mentee berhasil ditambahkan ke mentor ID {$mentor->id}!"
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $mentee->id,
            'mentor_id' => $mentor->id,
        ]);
    }
}
