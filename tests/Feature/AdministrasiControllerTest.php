<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pengajuan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdministrasiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_successful_response()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('administrasi.index'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.seleksi.administrasi.index');
    }

    public function test_dokumen_method_returns_expected_content()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $mentee = User::create([
            'name' => 'Mentee',
            'email' => 'mentee@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $pengajuan = Pengajuan::create([
            'user_id' => $mentee->id,
            'status_administrasi' => 'belum',
            'status' => 'belum',
        ]);

        $this->actingAs($admin);

        $response = $this->get('/administrasi/' . $pengajuan->id . '/dokumen');
        $response->assertStatus(200);
        $response->assertSee("Tampilan dokumen untuk Pengajuan ID: {$pengajuan->id}");
    }

    public function test_terima_pengajuan_successfully()
    {
        Mail::fake();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $mentee = User::create([
            'name' => 'Mentee',
            'email' => 'mentee@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $pengajuan = Pengajuan::create([
            'user_id' => $mentee->id,
            'status_administrasi' => 'belum',
            'status' => 'belum',
        ]);

        $pengajuan->setRelation('nama', $mentee);

        $this->actingAs($admin);

        $response = $this->post(route('administrasi.terima'), [
            'id' => $pengajuan->id,
        ]);

        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('pengajuan', [
            'id' => $pengajuan->id,
            'status_administrasi' => 'diterima',
        ]);
    }

    public function test_tolak_pengajuan_successfully()
    {
        Mail::fake();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $mentee = User::create([
            'name' => 'Mentee',
            'email' => 'mentee@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $pengajuan = Pengajuan::create([
            'user_id' => $mentee->id,
            'status_administrasi' => 'belum',
            'status' => 'belum',
        ]);

        $pengajuan->setRelation('nama', $mentee);

        $this->actingAs($admin);

        $response = $this->post(route('administrasi.tolak'), [
            'id' => $pengajuan->id,
            'catatan_tolak_administrasi' => 'Berkas tidak lengkap',
        ]);

        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('pengajuan', [
            'id' => $pengajuan->id,
            'status_administrasi' => 'ditolak',
            'catatan_tolak_administrasi' => 'Berkas tidak lengkap',
        ]);
    }
}
