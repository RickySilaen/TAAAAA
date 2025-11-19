<?php

namespace Tests\Unit;

use App\Models\Laporan;
use App\Models\User;
use Tests\TestCase;

class LaporanModelTest extends TestCase
{
    /**
     * Test laporan can be created with valid attributes.
     */
    public function test_laporan_can_be_created(): void
    {
        $user = User::factory()->create();

        $laporan = Laporan::create([
            'user_id' => $user->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => now(),
            'status' => 'pending',
            'luas_lahan' => 1.5,
            'kualitas_panen' => 'Baik',
            'catatan' => 'Test catatan',
        ]);

        $this->assertDatabaseHas('laporans', [
            'user_id' => $user->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
        ]);

        $this->assertEquals('Padi', $laporan->jenis_tanaman);
        $this->assertEquals(1000, $laporan->hasil_panen);
        $this->assertEquals('pending', $laporan->status);
    }

    /**
     * Test laporan belongs to user.
     */
    public function test_laporan_belongs_to_user(): void
    {
        $user = User::factory()->create(['name' => 'Petani Test']);

        $laporan = Laporan::create([
            'user_id' => $user->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $this->assertInstanceOf(User::class, $laporan->user);
        $this->assertEquals('Petani Test', $laporan->user->name);
        $this->assertEquals($user->id, $laporan->user_id);
    }

    /**
     * Test laporan status can be updated.
     */
    public function test_laporan_status_can_be_updated(): void
    {
        $user = User::factory()->create();

        $laporan = Laporan::create([
            'user_id' => $user->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $this->assertEquals('pending', $laporan->status);

        $laporan->update(['status' => 'verified']);

        $this->assertEquals('verified', $laporan->fresh()->status);
    }

    /**
     * Test laporan can have various status values.
     */
    public function test_laporan_can_have_various_statuses(): void
    {
        $user = User::factory()->create();

        $laporanPending = Laporan::create([
            'user_id' => $user->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $laporanVerified = Laporan::create([
            'user_id' => $user->id,
            'jenis_tanaman' => 'Jagung',
            'hasil_panen' => 500,
            'tanggal_panen' => now(),
            'status' => 'verified',
        ]);

        $laporanRejected = Laporan::create([
            'user_id' => $user->id,
            'jenis_tanaman' => 'Kedelai',
            'hasil_panen' => 300,
            'tanggal_panen' => now(),
            'status' => 'rejected',
        ]);

        $this->assertEquals('pending', $laporanPending->status);
        $this->assertEquals('verified', $laporanVerified->status);
        $this->assertEquals('rejected', $laporanRejected->status);
    }

    /**
     * Test laporan fillable attributes.
     */
    public function test_laporan_fillable_attributes(): void
    {
        $laporan = new Laporan();
        $fillable = $laporan->getFillable();

        $this->assertContains('user_id', $fillable);
        $this->assertContains('jenis_tanaman', $fillable);
        $this->assertContains('hasil_panen', $fillable);
        $this->assertContains('tanggal_panen', $fillable);
        $this->assertContains('status', $fillable);
    }

    /**
     * Test laporan can be deleted.
     */
    public function test_laporan_can_be_deleted(): void
    {
        $user = User::factory()->create();

        $laporan = Laporan::create([
            'user_id' => $user->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $laporanId = $laporan->id;

        $laporan->delete();

        $this->assertDatabaseMissing('laporans', [
            'id' => $laporanId,
        ]);
    }

    /**
     * Test laporan has tanggal panen attribute.
     */
    public function test_laporan_has_tanggal_panen(): void
    {
        $user = User::factory()->create();
        $tanggalPanen = now()->subDays(5);

        $laporan = Laporan::create([
            'user_id' => $user->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => $tanggalPanen,
            'status' => 'pending',
        ]);

        $this->assertEquals($tanggalPanen->format('Y-m-d'), $laporan->tanggal_panen->format('Y-m-d'));
    }

    /**
     * Test laporan hasil panen is numeric.
     */
    public function test_laporan_hasil_panen_is_numeric(): void
    {
        $user = User::factory()->create();

        $laporan = Laporan::create([
            'user_id' => $user->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1500.5,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $this->assertIsNumeric($laporan->hasil_panen);
        $this->assertEquals(1500.5, $laporan->hasil_panen);
    }
}
