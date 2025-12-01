<?php

namespace Tests\Feature\Petani;

use App\Models\Laporan;
use App\Models\User;
use Tests\TestCase;

class PetaniLaporanTest extends TestCase
{
    /**
     * Test petani can view their laporan index.
     */
    public function test_petani_can_view_their_laporan_index(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $response = $this->actingAs($petani)->get('/petani/laporan');

        $response->assertStatus(200);
        $response->assertViewIs('petani.laporan.index');
        $response->assertViewHas('laporans');
    }

    /**
     * Test petani can create laporan.
     */
    public function test_petani_can_create_laporan(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $response = $this->actingAs($petani)
            ->withoutMiddleware()
            ->post('/petani/laporan', [
                'jenis_tanaman' => 'Padi',
                'hasil_panen' => 1500,
                'tanggal_panen' => now()->format('Y-m-d'),
                'luas_lahan' => 2.5,
                'kualitas_panen' => 'Baik',
                'catatan' => 'Panen tahun ini sangat baik',
            ]);

        $this->assertDatabaseHas('laporans', [
            'user_id' => $petani->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1500,
            'status' => 'pending',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /**
     * Test petani can view their own laporan.
     */
    public function test_petani_can_view_their_own_laporan(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $laporan = Laporan::create([
            'user_id' => $petani->id,
            'jenis_tanaman' => 'Jagung',
            'hasil_panen' => 800,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $response = $this->actingAs($petani)->get("/petani/laporan/{$laporan->id}");

        $response->assertStatus(200);
        $response->assertViewHas('laporan', $laporan);
    }

    /**
     * Test petani can edit their own laporan.
     */
    public function test_petani_can_edit_their_own_laporan(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $laporan = Laporan::create([
            'user_id' => $petani->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $response = $this->actingAs($petani)->put("/petani/laporan/{$laporan->id}", [
            'jenis_tanaman' => 'Padi Hibrida',
            'hasil_panen' => 1200,
            'tanggal_panen' => now()->format('Y-m-d'),
            'luas_lahan' => 2.0,
            'kualitas_panen' => 'Sangat Baik',
        ]);

        $this->assertDatabaseHas('laporans', [
            'id' => $laporan->id,
            'jenis_tanaman' => 'Padi Hibrida',
            'hasil_panen' => 1200,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /**
     * Test petani cannot edit other petani's laporan.
     */
    public function test_petani_cannot_edit_other_petani_laporan(): void
    {
        $petani1 = User::factory()->create(['role' => 'petani', 'is_verified' => true]);
        $petani2 = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $laporan = Laporan::create([
            'user_id' => $petani2->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $response = $this->actingAs($petani1)->get("/petani/laporan/{$laporan->id}/edit");

        $response->assertStatus(404);
    }

    /**
     * Test petani can delete their own laporan.
     */
    public function test_petani_can_delete_their_own_laporan(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $laporan = Laporan::create([
            'user_id' => $petani->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $laporanId = $laporan->id;

        $response = $this->actingAs($petani)->delete("/petani/laporan/{$laporan->id}");

        $this->assertDatabaseMissing('laporans', [
            'id' => $laporanId,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /**
     * Test laporan creation requires jenis_tanaman.
     */
    public function test_laporan_creation_requires_jenis_tanaman(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $response = $this->actingAs($petani)->withoutMiddleware()->post('/petani/laporan', [
            'hasil_panen' => 1000,
            'tanggal_panen' => now()->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('jenis_tanaman');
    }

    /**
     * Test laporan creation requires hasil_panen.
     */
    public function test_laporan_creation_requires_hasil_panen(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $response = $this->actingAs($petani)->withoutMiddleware()->post('/petani/laporan', [
            'jenis_tanaman' => 'Padi',
            'tanggal_panen' => now()->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('hasil_panen');
    }

    /**
     * Test laporan creation requires tanggal_panen.
     */
    public function test_laporan_creation_requires_tanggal_panen(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $response = $this->actingAs($petani)->withoutMiddleware()->post('/petani/laporan', [
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
        ]);

        $response->assertSessionHasErrors('tanggal_panen');
    }

    /**
     * Test unverified petani cannot create laporan.
     */
    public function test_unverified_petani_cannot_create_laporan(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => false]);

        $response = $this->actingAs($petani)->get('/petani/laporan');

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error');
    }
}
