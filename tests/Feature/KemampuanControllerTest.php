<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pengajuan;
use App\Models\Soal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class KemampuanControllerTest extends TestCase
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

        $response = $this->get(route('kemampuan.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.seleksi.kemampuan.index');
    }

    public function test_show_page_displays_correct_data()
    {
        $user = User::create([
            'name' => 'Mentee',
            'email' => 'mentee@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $soal = Soal::create([
            'deskripsi' => 'Tes Logika',
            'soal' => 'Apa hasil dari 2 + 2?',
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(3),
        ]);

        $pengajuan = Pengajuan::create([
            'user_id' => $user->id,
            'soal_id' => $soal->id,
            'status_administrasi' => 'diterima',
            'status_tes_kemampuan' => 'belumDiproses',
            'status' => 'belumDiproses',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('kemampuan.show', $pengajuan->id));
        $response->assertStatus(200);
        $response->assertViewIs('pages.seleksi.kemampuan.show_soal');
        $response->assertSee($soal->soal);
    }

    public function test_store_creates_new_soal_and_updates_pengajuan()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $user = User::create([
            'name' => 'Mentee',
            'email' => 'mentee@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $pengajuan = Pengajuan::create([
            'user_id' => $user->id,
            'status_administrasi' => 'diterima',
            'status_tes_kemampuan' => 'belumDiproses',
            'status' => 'belumDiproses',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('kemampuan.store'), [
            'id' => $pengajuan->id,
            'deskripsi' => 'Tes Kemampuan Umum',
            'soal' => 'Apa warna langit saat siang?',
            'tanggal_awal_seleksi' => now()->format('Y-m-d'),
            'tanggal_akhir_seleksi' => now()->addDays(2)->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('kemampuan.index'));

        $this->assertDatabaseHas('soal_kemampuan', [
            'soal' => 'Apa warna langit saat siang?',
        ]);

        $this->assertDatabaseHas('pengajuan', [
            'id' => $pengajuan->id,
            'soal_id' => Soal::where('soal', 'Apa warna langit saat siang?')->first()->id,
        ]);
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
            'status_administrasi' => 'diterima',
            'status_tes_kemampuan' => 'proses',
            'status' => 'tes_kemampuan',
        ]);

        $pengajuan->setRelation('nama', $mentee);

        $this->actingAs($admin);

        $response = $this->post(route('kemampuan.terima'), [
            'id' => $pengajuan->id,
        ]);

        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('pengajuan', [
            'id' => $pengajuan->id,
            'status_tes_kemampuan' => 'diterima',
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
            'status_administrasi' => 'diterima',
            'status_tes_kemampuan' => 'proses',
            'status' => 'tes_kemampuan',
        ]);

        $pengajuan->setRelation('nama', $mentee);

        $this->actingAs($admin);

        $response = $this->post(route('kemampuan.tolak'), [
            'id' => $pengajuan->id,
            'catatan_tolak_tes_kemampuan' => 'Jawaban tidak sesuai kriteria',
        ]);

        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('pengajuan', [
            'id' => $pengajuan->id,
            'status_tes_kemampuan' => 'ditolak',
            'catatan_tolak_tes_kemampuan' => 'Jawaban tidak sesuai kriteria',
        ]);
    }
}
