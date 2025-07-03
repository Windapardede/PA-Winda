<?php

namespace Tests\Feature;

use App\Models\Instansi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstansiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_can_be_accessed()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->get(route('instansi.index'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.masteradmin.instansi.index');
    }

    public function test_store_creates_new_instansi()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->post(route('instansi.store'), [
            'nama' => 'Instansi A',
            'kuota' => 20,
            'kuota_tersedia' => 20,
        ]);

        $response->assertRedirect(route('instansi.index'));
        $this->assertDatabaseHas('instansi', ['nama' => 'Instansi A']);
    }

    public function test_update_modifies_existing_instansi()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $instansi = Instansi::create([
            'nama' => 'Instansi Lama',
            'kuota' => 10,
            'kuota_tersedia' => 10,
        ]);

        $response = $this->put(route('instansi.update', $instansi), [
            'nama' => 'Instansi Baru',
            'kuota' => 15,
            'kuota_tersedia' => 15,
        ]);

        $response->assertRedirect(route('instansi.index'));
        $this->assertDatabaseHas('instansi', ['nama' => 'Instansi Baru']);
    }

    public function test_destroy_deletes_instansi()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $instansi = Instansi::create([
            'nama' => 'Instansi C',
            'kuota' => 5,
            'kuota_tersedia' => 5,
        ]);

        $response = $this->delete(route('instansi.destroy', $instansi));

        $response->assertRedirect(route('instansi.index'));
        $this->assertDatabaseMissing('instansi', ['id' => $instansi->id]);
    }

    public function test_blacklistunblacklist_toggles_status()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $instansi = Instansi::create([
            'nama' => 'Instansi Test',
            'kuota' => 10,
            'kuota_tersedia' => 10,
            'is_active' => 1,
        ]);

        $response = $this->post(route('instansi.blacklistunblacklist'), [
            'id' => $instansi->id,
            'is_active' => 0,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('instansi', [
            'id' => $instansi->id,
            'is_active' => 0,
        ]);
    }
}
