<?php

namespace Tests\Feature\Petugas;

use App\Models\User;
use Tests\TestCase;

class PetugasPetaniTest extends TestCase
{
    /**
     * Test petugas can view petani index.
     */
    public function test_petugas_can_view_petani_index(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);

        $response = $this->actingAs($petugas)->get('/petugas/petani');

        $response->assertStatus(200);
        $response->assertViewIs('petugas.petani.index');
        $response->assertViewHas('petanis');
    }

    /**
     * Test petugas can view petani detail.
     */
    public function test_petugas_can_view_petani_detail(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => false]);

        $response = $this->actingAs($petugas)->get("/petugas/petani/{$petani->id}");

        $response->assertStatus(200);
        $response->assertViewIs('petugas.petani.show');
        $response->assertViewHas('petani', $petani);
    }

    /**
     * Test petugas can verify petani.
     */
    public function test_petugas_can_verify_petani(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $petani = User::factory()->create([
            'role' => 'petani',
            'is_verified' => false,
        ]);

        $response = $this->actingAs($petugas)->withoutMiddleware()->post("/petugas/petani/{$petani->id}/verify");

        $this->assertDatabaseHas('users', [
            'id' => $petani->id,
            'is_verified' => true,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /**
     * Test petugas can reject petani.
     */
    public function test_petugas_can_reject_petani(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $petani = User::factory()->create([
            'role' => 'petani',
            'is_verified' => false,
        ]);

        $petaniId = $petani->id;

        $response = $this->withoutMiddleware()->actingAs($petugas)->delete("/petugas/petani/{$petani->id}/reject");

        $this->assertDatabaseMissing('users', [
            'id' => $petaniId,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /**
     * Test non-petugas cannot access petani verification.
     */
    public function test_non_petugas_cannot_access_petani_verification(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/petugas/petani');

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error');
    }

    /**
     * Test verified petani shows verified badge.
     */
    public function test_verified_petani_shows_verified_badge(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $petani = User::factory()->create([
            'role' => 'petani',
            'is_verified' => true,
        ]);

        $response = $this->actingAs($petugas)->get('/petugas/petani');

        $response->assertSeeText($petani->name);
    }

    /**
     * Test unverified petani shows pending status.
     */
    public function test_unverified_petani_shows_pending_status(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $petani = User::factory()->create([
            'role' => 'petani',
            'is_verified' => false,
        ]);

        $response = $this->actingAs($petugas)->get('/petugas/petani');

        $response->assertSeeText($petani->name);
    }
}
