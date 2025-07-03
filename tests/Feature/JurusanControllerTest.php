<?php

namespace Tests\Feature;

use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JurusanControllerTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);
    }

    public function test_index_page_can_be_accessed()
    {
        $this->actingAsAdmin();

        $response = $this->get(route('jurusan.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.masteradmin.jurusan.index');
    }

    public function test_store_creates_new_jurusan()
    {
        $this->actingAsAdmin();

        $response = $this->post(route('jurusan.store'), [
            'nama' => 'Teknik Informatika'
        ]);

        $response->assertRedirect(route('jurusan.index'));
        $this->assertDatabaseHas('jurusan', ['nama' => 'Teknik Informatika']);
    }

    public function test_update_existing_jurusan()
    {
        $this->actingAsAdmin();

        $jurusan = Jurusan::create(['nama' => 'TI Lama']);

        $response = $this->put(route('jurusan.update', $jurusan->id), [
            'nama' => 'Teknik Informatika Baru'
        ]);

        $response->assertRedirect(route('jurusan.index'));
        $this->assertDatabaseHas('jurusan', ['nama' => 'Teknik Informatika Baru']);
    }

    public function test_destroy_jurusan()
    {
        $this->actingAsAdmin();

        $jurusan = Jurusan::create(['nama' => 'TI Hapus']);

        $response = $this->delete(route('jurusan.destroy', $jurusan->id));

        $response->assertRedirect(route('jurusan.index'));
        $this->assertDatabaseMissing('jurusan', ['nama' => 'TI Hapus']);
    }
}
