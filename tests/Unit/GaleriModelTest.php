<?php

namespace Tests\Unit;

use App\Models\Galeri;
use Tests\TestCase;

class GaleriModelTest extends TestCase
{
    /**
     * Test galeri can be created with valid attributes.
     */
    public function test_galeri_can_be_created(): void
    {
        $galeri = Galeri::create([
            'judul' => 'Test Galeri Pertanian',
            'deskripsi' => 'Deskripsi test galeri',
            'gambar' => 'test-galeri.jpg',
            'kategori' => 'Panen',
        ]);

        $this->assertDatabaseHas('galeris', [
            'judul' => 'Test Galeri Pertanian',
            'kategori' => 'Panen',
        ]);

        $this->assertEquals('Test Galeri Pertanian', $galeri->judul);
        $this->assertEquals('Panen', $galeri->kategori);
    }

    /**
     * Test galeri fillable attributes.
     */
    public function test_galeri_fillable_attributes(): void
    {
        $galeri = new Galeri();
        $fillable = $galeri->getFillable();

        $this->assertContains('judul', $fillable);
        $this->assertContains('deskripsi', $fillable);
        $this->assertContains('gambar', $fillable);
        $this->assertContains('kategori', $fillable);
    }

    /**
     * Test galeri can be deleted.
     */
    public function test_galeri_can_be_deleted(): void
    {
        $galeri = Galeri::create([
            'judul' => 'Test Galeri',
            'deskripsi' => 'Test deskripsi',
            'gambar' => 'test.jpg',
        ]);

        $galeriId = $galeri->id;

        $galeri->delete();

        $this->assertDatabaseMissing('galeris', [
            'id' => $galeriId,
        ]);
    }
}
