<?php

namespace Tests\Feature\Petugas;

use App\Models\Laporan;
use App\Models\User;
use Tests\TestCase;

class PetugasLaporanTest extends TestCase
{
    /**
     * Test petugas can view laporan index.
     */
    public function test_petugas_can_view_laporan_index(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);

        $response = $this->actingAs($petugas)->get('/petugas/laporan');

        $response->assertStatus(200);
        $response->assertViewIs('petugas.laporan.index');
        $response->assertViewHas('laporans');
    }

    /**
     * Test non-petugas cannot access petugas laporan index.
     */
    public function test_non_petugas_cannot_access_laporan_index(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $response = $this->actingAs($petani)->get('/petugas/laporan');

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error');
    }

    /**
     * Test petugas can view laporan detail.
     */
    public function test_petugas_can_view_laporan_detail(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $laporan = Laporan::create([
            'user_id' => $petani->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $response = $this->actingAs($petugas)->get("/petugas/laporan/{$laporan->id}");

        $response->assertStatus(200);
        $response->assertViewIs('petugas.laporan.show');
        $response->assertViewHas('laporan', $laporan);
    }

    /**
     * Test petugas can verify laporan.
     */
    public function test_petugas_can_verify_laporan(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $laporan = Laporan::create([
            'user_id' => $petani->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $response = $this->withoutMiddleware()->actingAs($petugas)->post("/petugas/laporan/{$laporan->id}/verify");

        $this->assertDatabaseHas('laporans', [
            'id' => $laporan->id,
            'status' => 'verified',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /**
     * Test petugas can reject laporan.
     */
    public function test_petugas_can_reject_laporan(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $laporan = Laporan::create([
            'user_id' => $petani->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $response = $this->withoutMiddleware()->actingAs($petugas)->delete("/petugas/laporan/{$laporan->id}/reject", [
            'alasan' => 'Data tidak valid',
        ]);

        $this->assertDatabaseHas('laporans', [
            'id' => $laporan->id,
            'status' => 'rejected',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /**
     * Test petani cannot verify laporan.
     */
    public function test_petani_cannot_verify_laporan(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $laporan = Laporan::create([
            'user_id' => $petani->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $response = $this->actingAs($petani)->post("/petugas/laporan/{$laporan->id}/verify");

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error');
    }
}
