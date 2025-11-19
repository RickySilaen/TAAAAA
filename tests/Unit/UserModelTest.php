<?php

namespace Tests\Unit;

use App\Models\Bantuan;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    /**
     * Test user can be created with valid attributes.
     */
    public function test_user_can_be_created(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'petani',
            'is_verified' => false,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'petani',
        ]);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('petani', $user->role);
        $this->assertFalse($user->is_verified);
    }

    /**
     * Test user password is hashed.
     */
    public function test_user_password_is_hashed(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'petani',
        ]);

        $this->assertTrue(Hash::check('password', $user->password));
        $this->assertNotEquals('password', $user->password);
    }

    /**
     * Test user has role attribute.
     */
    public function test_user_has_role_attribute(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $petugasUser = User::factory()->create(['role' => 'petugas']);
        $petaniUser = User::factory()->create(['role' => 'petani']);

        $this->assertEquals('admin', $adminUser->role);
        $this->assertEquals('petugas', $petugasUser->role);
        $this->assertEquals('petani', $petaniUser->role);
    }

    /**
     * Test user can be verified.
     */
    public function test_user_can_be_verified(): void
    {
        $user = User::factory()->create([
            'role' => 'petani',
            'is_verified' => false,
        ]);

        $this->assertFalse($user->is_verified);

        $user->update(['is_verified' => true]);

        $this->assertTrue($user->fresh()->is_verified);
    }

    /**
     * Test user has many laporans relationship.
     */
    public function test_user_has_many_laporans(): void
    {
        $user = User::factory()->create();

        $laporan1 = Laporan::create([
            'user_id' => $user->id,
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1000,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $laporan2 = Laporan::create([
            'user_id' => $user->id,
            'jenis_tanaman' => 'Jagung',
            'hasil_panen' => 500,
            'tanggal_panen' => now(),
            'status' => 'pending',
        ]);

        $this->assertCount(2, $user->laporans);
        $this->assertTrue($user->laporans->contains($laporan1));
        $this->assertTrue($user->laporans->contains($laporan2));
    }

    /**
     * Test user has many bantuans relationship.
     */
    public function test_user_has_many_bantuans(): void
    {
        $user = User::factory()->create();

        $bantuan1 = Bantuan::create([
            'user_id' => $user->id,
            'jenis_bantuan' => 'Pupuk',
            'jumlah' => 100,
            'tanggal_permintaan' => now(),
            'status' => 'pending',
        ]);

        $bantuan2 = Bantuan::create([
            'user_id' => $user->id,
            'jenis_bantuan' => 'Bibit',
            'jumlah' => 50,
            'tanggal_permintaan' => now(),
            'status' => 'pending',
        ]);

        $this->assertCount(2, $user->bantuans);
        $this->assertTrue($user->bantuans->contains($bantuan1));
        $this->assertTrue($user->bantuans->contains($bantuan2));
    }

    /**
     * Test user fillable attributes.
     */
    public function test_user_fillable_attributes(): void
    {
        $user = new User();
        $fillable = $user->getFillable();

        $this->assertContains('name', $fillable);
        $this->assertContains('email', $fillable);
        $this->assertContains('password', $fillable);
        $this->assertContains('role', $fillable);
    }

    /**
     * Test user hidden attributes.
     */
    public function test_user_hidden_attributes(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'remember_token' => 'test-token',
        ]);

        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    /**
     * Test user can be deleted.
     */
    public function test_user_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $userId = $user->id;

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $userId,
        ]);
    }

    /**
     * Test user email must be unique.
     */
    public function test_user_email_must_be_unique(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        User::factory()->create(['email' => 'duplicate@example.com']);
        User::factory()->create(['email' => 'duplicate@example.com']);
    }
}
