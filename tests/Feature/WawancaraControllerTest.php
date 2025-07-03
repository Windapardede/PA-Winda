<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pengajuan;
use App\Models\Instansi;
use App\Models\Posisi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class WawancaraControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_can_be_accessed()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('wawancara.index'));
        $response->assertStatus(200);
    }
    public function test_unggah_wawancara_successfully()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $pengajuan = Pengajuan::create([
            'user_id' => $user->id,
            'status_tes_kemampuan' => 'diterima',
        ]);

        $this->actingAs($admin);

        $data = [
            'tanggal_wawancara' => '2025-07-01',
            'jam_wawancara' => '10:00',
            'link_wawancara' => 'https://example.com/meet',
        ];

        $response = $this->put(route('wawancara.create', $pengajuan->id), $data);

        $response->assertRedirect(route('wawancara.index'));
        $this->assertDatabaseHas('pengajuan', [
            'id' => $pengajuan->id,
            'tanggal_wawancara' => '2025-07-01',
            'jam_wawancara' => '10:00:00',
            'link_wawancara' => 'https://example.com/meet',
        ]);
    }


    public function test_terima_wawancara_successfully()
    {
        Mail::fake();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $instansi = Instansi::create([
            'nama_instansi' => 'Instansi A',
            'kuota_tersedia' => 5,
        ]);

        $mentee = User::create([
            'name' => 'Mentee',
            'email' => 'mentee@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'instansi_id' => $instansi->id,
        ]);

        $posisi = Posisi::create([
            'posisi' => 'Frontend Dev',
            'kuota_tersedia' => 3,
        ]);

        $pengajuan = Pengajuan::create([
            'user_id' => $mentee->id,
            'posisi_id' => $posisi->id,
            'status_wawancara' => 'belumDiproses',
            'status' => 'proses',
        ]);

        $pengajuan->setRelation('nama', $mentee);

        $this->actingAs($admin);

        $response = $this->put(route('wawancara.terima', $pengajuan->id), [
            'catatan_terima_wawancara' => 'Selamat kamu diterima!',
        ]);

        $response->assertRedirect(route('wawancara.index'));
        $this->assertDatabaseHas('pengajuan', [
            'id' => $pengajuan->id,
            'status_wawancara' => 'diterima',
            'status' => 'diterima',
            'catatan_terima_wawancara' => 'Selamat kamu diterima!',
        ]);
    }

    public function test_tolak_wawancara_successfully()
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
            'status_wawancara' => 'belumDiproses',
            'status' => 'proses',
        ]);

        $pengajuan->setRelation('nama', $mentee);

        $this->actingAs($admin);

        $response = $this->put(route('wawancara.tolak', $pengajuan->id), [
            'catatan_tolak_wawancara' => 'Kurang meyakinkan.',
        ]);

        $response->assertSuccessful();
        $this->assertDatabaseHas('pengajuan', [
            'id' => $pengajuan->id,
            'status_wawancara' => 'ditolak',
            'status' => 'ditolak',
            'catatan_tolak_wawancara' => 'Kurang meyakinkan.',
        ]);
    }
}
