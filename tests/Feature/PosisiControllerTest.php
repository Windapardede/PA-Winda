<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Posisi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosisiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_can_be_accessed()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->get(route('masterposisi.index'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.masteradmin.posisi.index');
    }

    public function test_store_creates_new_posisi()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->post(route('masterposisi.store'), [
            'nama' => 'Frontend Developer',
            'total_kuota' => 5,
            'kuota_tersedia' => 5,
            'deskripsi' => 'Mengembangkan UI aplikasi',
            'persyaratan' => 'Menguasai HTML, CSS, JS',
        ]);

        $response->assertRedirect('masterposisi');
        $this->assertDatabaseHas('posisi', ['nama' => 'Frontend Developer']);
    }

    public function test_update_existing_posisi()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $posisi = Posisi::create([
            'nama' => 'Backend Developer',
            'total_kuota' => 3,
            'kuota_tersedia' => 3,
        ]);

        $response = $this->put(route('masterposisi.update', $posisi->id), [
            'id' => $posisi->id,
            'nama' => 'Backend Engineer',
            'total_kuota' => 4,
            'kuota_tersedia' => 4,
        ]);

        $response->assertRedirect('masterposisi');
        $this->assertDatabaseHas('posisi', ['nama' => 'Backend Engineer']);
    }

    public function test_delete_posisi()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $posisi = Posisi::create([
            'nama' => 'Tester',
            'total_kuota' => 2,
            'kuota_tersedia' => 2,
        ]);

        $response = $this->delete(route('masterposisi.destroy', $posisi->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('posisi', ['id' => $posisi->id]);
    }

    public function test_publish_unpublish_posisi()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $posisi = Posisi::create([
            'nama' => 'DevOps',
            'total_kuota' => 1,
            'kuota_tersedia' => 1,
            'status' => 'unpublish'
        ]);

        $response = $this->post(route('masterposisi.publishUnpublish'), [
            'id' => $posisi->id,
            'status' => 'publish',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posisi', ['id' => $posisi->id, 'status' => 'publish']);
    }
}
