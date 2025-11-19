<?php

namespace Tests\Unit;

use App\Models\Bantuan;
use App\Models\User;
use Tests\TestCase;

class BantuanModelTest extends TestCase
{
    /**
     * Test bantuan can be created with valid attributes.
     */
    public function test_bantuan_can_be_created(): void
    {
        $user = User::factory()->create();

        $bantuan = Bantuan::create([
            'user_id' => $user->id,
            'jenis_bantuan' => 'Pupuk',
            'jumlah' => 100,
            'tanggal_permintaan' => now(),
            'status' => 'pending',
            'keterangan' => 'Test keterangan',
        ]);

        $this->assertDatabaseHas('bantuans', [
            'user_id' => $user->id,
            'jenis_bantuan' => 'Pupuk',
            'jumlah' => 100,
        ]);

        $this->assertEquals('Pupuk', $bantuan->jenis_bantuan);
        $this->assertEquals(100, $bantuan->jumlah);
        $this->assertEquals('pending', $bantuan->status);
    }

    /**
     * Test bantuan belongs to user.
     */
    public function test_bantuan_belongs_to_user(): void
    {
        $user = User::factory()->create(['name' => 'Petani Test']);

        $bantuan = Bantuan::create([
            'user_id' => $user->id,
            'jenis_bantuan' => 'Bibit',
            'jumlah' => 50,
            'tanggal_permintaan' => now(),
            'status' => 'pending',
        ]);

        $this->assertInstanceOf(User::class, $bantuan->user);
        $this->assertEquals('Petani Test', $bantuan->user->name);
        $this->assertEquals($user->id, $bantuan->user_id);
    }

    /**
     * Test bantuan status can be updated.
     */
    public function test_bantuan_status_can_be_updated(): void
    {
        $user = User::factory()->create();

        $bantuan = Bantuan::create([
            'user_id' => $user->id,
            'jenis_bantuan' => 'Pupuk',
            'jumlah' => 100,
            'tanggal_permintaan' => now(),
            'status' => 'pending',
        ]);

        $this->assertEquals('pending', $bantuan->status);

        $bantuan->update(['status' => 'approved']);

        $this->assertEquals('approved', $bantuan->fresh()->status);
    }

    /**
     * Test bantuan can have various status values.
     */
    public function test_bantuan_can_have_various_statuses(): void
    {
        $user = User::factory()->create();

        $bantuanPending = Bantuan::create([
            'user_id' => $user->id,
            'jenis_bantuan' => 'Pupuk',
            'jumlah' => 100,
            'tanggal_permintaan' => now(),
            'status' => 'pending',
        ]);

        $bantuanApproved = Bantuan::create([
            'user_id' => $user->id,
            'jenis_bantuan' => 'Bibit',
            'jumlah' => 50,
            'tanggal_permintaan' => now(),
            'status' => 'approved',
        ]);

        $bantuanRejected = Bantuan::create([
            'user_id' => $user->id,
            'jenis_bantuan' => 'Alat',
            'jumlah' => 10,
            'tanggal_permintaan' => now(),
            'status' => 'rejected',
        ]);

        $this->assertEquals('pending', $bantuanPending->status);
        $this->assertEquals('approved', $bantuanApproved->status);
        $this->assertEquals('rejected', $bantuanRejected->status);
    }

    /**
     * Test bantuan fillable attributes.
     */
    public function test_bantuan_fillable_attributes(): void
    {
        $bantuan = new Bantuan();
        $fillable = $bantuan->getFillable();

        $this->assertContains('user_id', $fillable);
        $this->assertContains('jenis_bantuan', $fillable);
        $this->assertContains('jumlah', $fillable);
        $this->assertContains('tanggal_permintaan', $fillable);
        $this->assertContains('status', $fillable);
    }

    /**
     * Test bantuan can be deleted.
     */
    public function test_bantuan_can_be_deleted(): void
    {
        $user = User::factory()->create();

        $bantuan = Bantuan::create([
            'user_id' => $user->id,
            'jenis_bantuan' => 'Pupuk',
            'jumlah' => 100,
            'tanggal_permintaan' => now(),
            'status' => 'pending',
        ]);

        $bantuanId = $bantuan->id;

        $bantuan->delete();

        $this->assertDatabaseMissing('bantuans', [
            'id' => $bantuanId,
        ]);
    }

    /**
     * Test bantuan jumlah is numeric.
     */
    public function test_bantuan_jumlah_is_numeric(): void
    {
        $user = User::factory()->create();

        $bantuan = Bantuan::create([
            'user_id' => $user->id,
            'jenis_bantuan' => 'Pupuk',
            'jumlah' => 150,
            'tanggal_permintaan' => now(),
            'status' => 'pending',
        ]);

        $this->assertIsNumeric($bantuan->jumlah);
        $this->assertEquals(150, $bantuan->jumlah);
    }

    /**
     * Test bantuan has tanggal permintaan.
     */
    public function test_bantuan_has_tanggal_permintaan(): void
    {
        $user = User::factory()->create();
        $tanggalPermintaan = now()->subDays(3);

        $bantuan = Bantuan::create([
            'user_id' => $user->id,
            'jenis_bantuan' => 'Pupuk',
            'jumlah' => 100,
            'tanggal_permintaan' => $tanggalPermintaan,
            'status' => 'pending',
        ]);

        $this->assertEquals($tanggalPermintaan->format('Y-m-d'), $bantuan->tanggal_permintaan->format('Y-m-d'));
    }
}
