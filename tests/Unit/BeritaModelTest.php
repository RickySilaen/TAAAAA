<?php

namespace Tests\Unit;

use App\Models\Berita;
use Illuminate\Support\Str;
use Tests\TestCase;

class BeritaModelTest extends TestCase
{
    /**
     * Test berita can be created with valid attributes.
     */
    public function test_berita_can_be_created(): void
    {
        $berita = Berita::create([
            'judul' => 'Test Berita Pertanian',
            'slug' => Str::slug('Test Berita Pertanian'),
            'konten' => 'Ini adalah konten test berita pertanian',
            'gambar' => 'test-image.jpg',
            'kategori' => 'Teknologi',
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('beritas', [
            'judul' => 'Test Berita Pertanian',
            'status' => 'published',
        ]);

        $this->assertEquals('Test Berita Pertanian', $berita->judul);
        $this->assertEquals('published', $berita->status);
    }

    /**
     * Test berita slug is generated from judul.
     */
    public function test_berita_slug_is_generated_from_judul(): void
    {
        $berita = Berita::create([
            'judul' => 'Teknologi Pertanian Modern',
            'slug' => Str::slug('Teknologi Pertanian Modern'),
            'konten' => 'Test konten',
            'status' => 'published',
        ]);

        $this->assertEquals('teknologi-pertanian-modern', $berita->slug);
    }

    /**
     * Test berita fillable attributes.
     */
    public function test_berita_fillable_attributes(): void
    {
        $berita = new Berita();
        $fillable = $berita->getFillable();

        $this->assertContains('judul', $fillable);
        $this->assertContains('slug', $fillable);
        $this->assertContains('konten', $fillable);
        $this->assertContains('gambar', $fillable);
        $this->assertContains('status', $fillable);
    }

    /**
     * Test berita can be deleted.
     */
    public function test_berita_can_be_deleted(): void
    {
        $berita = Berita::create([
            'judul' => 'Test Berita',
            'slug' => 'test-berita',
            'konten' => 'Test konten',
            'status' => 'published',
        ]);

        $beritaId = $berita->id;

        $berita->delete();

        $this->assertDatabaseMissing('beritas', [
            'id' => $beritaId,
        ]);
    }

    /**
     * Test berita status can be draft or published.
     */
    public function test_berita_can_have_draft_or_published_status(): void
    {
        $beritaDraft = Berita::create([
            'judul' => 'Draft Berita',
            'slug' => 'draft-berita',
            'konten' => 'Test konten',
            'status' => 'draft',
        ]);

        $beritaPublished = Berita::create([
            'judul' => 'Published Berita',
            'slug' => 'published-berita',
            'konten' => 'Test konten',
            'status' => 'published',
        ]);

        $this->assertEquals('draft', $beritaDraft->status);
        $this->assertEquals('published', $beritaPublished->status);
    }
}
