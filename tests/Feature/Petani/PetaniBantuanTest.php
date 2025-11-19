<?php

namespace Tests\Feature\Petani;

use App\Models\Bantuan;
use App\Models\User;
use Tests\TestCase;

class PetaniBantuanTest extends TestCase
{
    /**
     * Test petani can view their bantuan index.
     */
    public function test_petani_can_view_their_bantuan_index(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $response = $this->actingAs($petani)->get('/petani/bantuan');

        $response->assertStatus(200);
        $response->assertViewIs('petani.bantuan.index');
        $response->assertViewHas('bantuans');
    }

    /**
     * Test petani can create bantuan request.
     */
    public function test_petani_can_create_bantuan_request(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $response = $this->actingAs($petani)->post('/petani/bantuan', [
            'jenis_bantuan' => 'Pupuk',
            'jumlah' => 100,
            'tanggal_permintaan' => now()->format('Y-m-d'),
            'keterangan' => 'Membutuhkan pupuk untuk musim tanam',
        ]);

        $this->assertDatabaseHas('bantuans', [
            'user_id' => $petani->id,
            'jenis_bantuan' => 'Pupuk',
            'jumlah' => 100,
            'status' => 'pending',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /**
     * Test petani can view their own bantuan.
     */
    public function test_petani_can_view_their_own_bantuan(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $bantuan = Bantuan::create([
            'user_id' => $petani->id,
            'jenis_bantuan' => 'Bibit',
            'jumlah' => 50,
            'tanggal_permintaan' => now(),
            'status' => 'pending',
        ]);

        $response = $this->actingAs($petani)->get("/petani/bantuan/{$bantuan->id}");

        $response->assertStatus(200);
        $response->assertViewHas('bantuan', $bantuan);
    }

    /**
     * Test petani can edit their pending bantuan.
     */
    public function test_petani_can_edit_their_pending_bantuan(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $bantuan = Bantuan::create([
            'user_id' => $petani->id,
            'jenis_bantuan' => 'Pupuk',
            'jumlah' => 100,
            'tanggal_permintaan' => now(),
            'status' => 'pending',
        ]);

        $response = $this->actingAs($petani)->put("/petani/bantuan/{$bantuan->id}", [
            'jenis_bantuan' => 'Pupuk Organik',
            'jumlah' => 150,
            'tanggal_permintaan' => now()->format('Y-m-d'),
            'keterangan' => 'Updated keterangan',
        ]);

        $this->assertDatabaseHas('bantuans', [
            'id' => $bantuan->id,
            'jenis_bantuan' => 'Pupuk Organik',
            'jumlah' => 150,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /**
     * Test petani cannot edit other petani's bantuan.
     */
    public function test_petani_cannot_edit_other_petani_bantuan(): void
    {
        $petani1 = User::factory()->create(['role' => 'petani', 'is_verified' => true]);
        $petani2 = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $bantuan = Bantuan::create([
            'user_id' => $petani2->id,
            'jenis_bantuan' => 'Pupuk',
            'jumlah' => 100,
            'tanggal_permintaan' => now(),
            'status' => 'pending',
        ]);

        $response = $this->actingAs($petani1)->get("/petani/bantuan/{$bantuan->id}/edit");

        $response->assertStatus(404);
    }

    /**
     * Test petani can delete their pending bantuan.
     */
    public function test_petani_can_delete_their_pending_bantuan(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $bantuan = Bantuan::create([
            'user_id' => $petani->id,
            'jenis_bantuan' => 'Pupuk',
            'jumlah' => 100,
            'tanggal_permintaan' => now(),
            'status' => 'pending',
        ]);

        $bantuanId = $bantuan->id;

        $response = $this->actingAs($petani)->delete("/petani/bantuan/{$bantuan->id}");

        $this->assertDatabaseMissing('bantuans', [
            'id' => $bantuanId,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /**
     * Test bantuan creation requires jenis_bantuan.
     */
    public function test_bantuan_creation_requires_jenis_bantuan(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $response = $this->actingAs($petani)->post('/petani/bantuan', [
            'jumlah' => 100,
            'tanggal_permintaan' => now()->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('jenis_bantuan');
    }

    /**
     * Test bantuan creation requires jumlah.
     */
    public function test_bantuan_creation_requires_jumlah(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $response = $this->actingAs($petani)->post('/petani/bantuan', [
            'jenis_bantuan' => 'Pupuk',
            'tanggal_permintaan' => now()->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('jumlah');
    }
}
