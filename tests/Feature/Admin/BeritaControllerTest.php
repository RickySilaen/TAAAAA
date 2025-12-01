<?php

namespace Tests\Feature\Admin;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class BeritaControllerTest extends TestCase
{
    /**
     * Test admin can view berita index page.
     */
    public function test_admin_can_view_berita_index(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/berita');

        $response->assertStatus(200);
        $response->assertViewIs('admin.berita.index');
        $response->assertViewHas('beritas');
    }

    /**
     * Test non-admin cannot access berita index.
     */
    public function test_non_admin_cannot_access_berita_index(): void
    {
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        $response = $this->actingAs($petani)->get('/admin/berita');

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error');
    }

    /**
     * Test guest cannot access berita index.
     */
    public function test_guest_cannot_access_berita_index(): void
    {
        $response = $this->get('/admin/berita');

        $response->assertRedirect('/login');
    }

    /**
     * Test admin can view create berita page.
     */
    public function test_admin_can_view_create_berita_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/berita/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.berita.create');
    }

    /**
     * Test admin can create berita.
     */
    public function test_admin_can_create_berita(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->withoutMiddleware()->post('/admin/berita', [
            'judul' => 'Test Berita Pertanian',
            'konten' => 'Ini adalah konten test berita pertanian yang sangat panjang dan detail',
            'kategori' => 'Teknologi',
            'status' => 'published',
            'gambar' => UploadedFile::fake()->image('berita.jpg'),
        ]);

        $this->assertDatabaseHas('beritas', [
            'judul' => 'Test Berita Pertanian',
            'kategori' => 'Teknologi',
            'status' => 'published',
        ]);

        $response->assertRedirect('/admin/berita');
        $response->assertSessionHas('success');
    }

    /**
     * Test admin can view edit berita page.
     */
    public function test_admin_can_view_edit_berita_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $berita = Berita::create([
            'judul' => 'Test Berita',
            'slug' => Str::slug('Test Berita'),
            'konten' => 'Test konten',
            'status' => 'published',
        ]);

        $response = $this->actingAs($admin)->get("/admin/berita/{$berita->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.berita.edit');
        $response->assertViewHas('berita', $berita);
    }

    /**
     * Test admin can update berita.
     */
    public function test_admin_can_update_berita(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $berita = Berita::create([
            'judul' => 'Old Berita',
            'slug' => Str::slug('Old Berita'),
            'konten' => 'Old konten',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($admin)->withoutMiddleware()->put("/admin/berita/{$berita->id}", [
            'judul' => 'Updated Berita',
            'konten' => 'Updated konten yang lebih panjang',
            'kategori' => 'Updated Kategori',
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('beritas', [
            'id' => $berita->id,
            'judul' => 'Updated Berita',
            'status' => 'published',
        ]);

        $response->assertRedirect('/admin/berita');
        $response->assertSessionHas('success');
    }

    /**
     * Test admin can delete berita.
     */
    public function test_admin_can_delete_berita(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $berita = Berita::create([
            'judul' => 'Test Berita',
            'slug' => Str::slug('Test Berita'),
            'konten' => 'Test konten',
            'status' => 'published',
        ]);

        $response = $this->actingAs($admin)->withoutMiddleware()->delete("/admin/berita/{$berita->id}");

        $this->assertDatabaseMissing('beritas', [
            'id' => $berita->id,
        ]);

        $response->assertRedirect('/admin/berita');
        $response->assertSessionHas('success');
    }

    /**
     * Test berita creation requires judul.
     */
    public function test_berita_creation_requires_judul(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->withoutMiddleware()->post('/admin/berita', [
            'konten' => 'Test konten',
            'status' => 'published',
        ]);

        $response->assertSessionHasErrors('judul');
    }

    /**
     * Test berita creation requires konten.
     */
    public function test_berita_creation_requires_konten(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->withoutMiddleware()->post('/admin/berita', [
            'judul' => 'Test Berita',
            'status' => 'published',
        ]);

        $response->assertSessionHasErrors('konten');
    }

    /**
     * Test berita slug is generated automatically.
     */
    public function test_berita_slug_is_generated_automatically(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->withoutMiddleware()->post('/admin/berita', [
            'judul' => 'Test Berita Pertanian Modern',
            'konten' => 'Test konten yang panjang',
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('beritas', [
            'judul' => 'Test Berita Pertanian Modern',
            'slug' => 'test-berita-pertanian-modern',
        ]);
    }
}
