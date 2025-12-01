<?php

namespace Tests\Feature\Admin;

use App\Models\Galeri;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GaleriControllerTest extends TestCase
{
    /**
     * Test admin can view galeri index page.
     */
    public function test_admin_can_view_galeri_index(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/galeri');

        $response->assertStatus(200);
        $response->assertViewIs('admin.galeri.index');
        $response->assertViewHas('galeris');
    }

    /**
     * Test non-admin cannot access galeri index.
     */
    public function test_non_admin_cannot_access_galeri_index(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);

        $response = $this->actingAs($petugas)->get('/admin/galeri');

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error');
    }

    /**
     * Test admin can create galeri.
     */
    public function test_admin_can_create_galeri(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->withoutMiddleware()->post('/admin/galeri', [
            'judul' => 'Test Galeri Panen',
            'deskripsi' => 'Deskripsi test galeri panen',
            'kategori' => 'Panen',
            'gambar' => UploadedFile::fake()->image('galeri.jpg'),
        ]);

        $this->assertDatabaseHas('galeris', [
            'judul' => 'Test Galeri Panen',
            'kategori' => 'Panen',
        ]);

        $response->assertRedirect('/admin/galeri');
        $response->assertSessionHas('success');
    }

    /**
     * Test admin can update galeri.
     */
    public function test_admin_can_update_galeri(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $galeri = Galeri::create([
            'judul' => 'Old Galeri',
            'deskripsi' => 'Old deskripsi',
            'gambar' => 'old-image.jpg',
        ]);

        $response = $this->actingAs($admin)->withoutMiddleware()->put("/admin/galeri/{$galeri->id}", [
            'judul' => 'Updated Galeri',
            'deskripsi' => 'Updated deskripsi',
            'kategori' => 'Penanaman',
        ]);

        $this->assertDatabaseHas('galeris', [
            'id' => $galeri->id,
            'judul' => 'Updated Galeri',
        ]);

        $response->assertRedirect('/admin/galeri');
        $response->assertSessionHas('success');
    }

    /**
     * Test admin can delete galeri.
     */
    public function test_admin_can_delete_galeri(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $galeri = Galeri::create([
            'judul' => 'Test Galeri',
            'deskripsi' => 'Test deskripsi',
            'gambar' => 'test.jpg',
        ]);

        $response = $this->actingAs($admin)->withoutMiddleware()->delete("/admin/galeri/{$galeri->id}");

        $this->assertDatabaseMissing('galeris', [
            'id' => $galeri->id,
        ]);

        $response->assertRedirect('/admin/galeri');
        $response->assertSessionHas('success');
    }

    /**
     * Test galeri creation requires judul.
     */
    public function test_galeri_creation_requires_judul(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->withoutMiddleware()->post('/admin/galeri', [
            'deskripsi' => 'Test deskripsi',
        ]);

        $response->assertSessionHasErrors('judul');
    }

    /**
     * Test galeri creation requires gambar.
     */
    public function test_galeri_creation_requires_gambar(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->withoutMiddleware()->post('/admin/galeri', [
            'judul' => 'Test Galeri',
            'deskripsi' => 'Test deskripsi',
        ]);

        $response->assertSessionHasErrors('gambar');
    }
}
