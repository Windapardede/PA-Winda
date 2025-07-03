<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Posisi;
use App\Models\Pengajuan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosisiUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_posisi_list_to_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Posisi::factory()->count(2)->create(['status' => 'publish']);
        Pengajuan::factory()->create([
            'user_id' => $user->id,
            'status' => 'ditolak' // tidak mempengaruhi flag status
        ]);

        $response = $this->get(route('user.posisi.index')); // pastikan route sesuai

        $response->assertStatus(200);
        $response->assertViewIs('pages.user.posisi');
        $response->assertViewHas('user');
        $response->assertViewHas('status', true);
    }

    /** @test */
    public function it_sets_status_false_if_user_has_ongoing_pengajuan()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Posisi::factory()->create(['status' => 'publish']);
        Pengajuan::factory()->create([
            'user_id' => $user->id,
            'status' => 'diterima' // menyebabkan flag status = false
        ]);

        $response = $this->get(route('user.posisi.index'));

        $response->assertStatus(200);
        $response->assertViewHas('status', false);
    }

    /** @test */
    public function it_shows_posisiaktif_view_for_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Posisi::factory()->count(3)->create(['status' => 'publish']);
        Pengajuan::factory()->create([
            'user_id' => $user->id,
            'status' => 'belumDiproses'
        ]);

        $response = $this->get(route('user.posisi.aktif')); // sesuaikan dengan route posisiaktif()

        $response->assertStatus(200);
        $response->assertViewIs('pages.user.have_acc.posisi.index');
        $response->assertViewHas('posisiaktif');
        $response->assertViewHas('status', false);
    }
}
