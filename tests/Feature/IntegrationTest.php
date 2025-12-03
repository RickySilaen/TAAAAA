<?php

namespace Tests\Feature;

use App\Models\Bantuan;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class IntegrationTest extends TestCase
{
    /**
     * Test complete petani registration and verification flow.
     */
    public function test_complete_petani_registration_and_verification_flow(): void
    {
        Notification::fake();

        // Step 1: Petani registers
        $this->withSession([])->post('/register', [
            'name' => 'Integration Test Petani',
            'email' => 'integration@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'alamat_desa' => 'Desa Integration',
            'alamat_kecamatan' => 'Kecamatan Test',
            'luas_lahan' => 2.5,
            '_token' => csrf_token(),
        ]);

        $petani = User::where('email', 'integration@example.com')->first();
        $this->assertNotNull($petani);
        $this->assertEquals('petani', $petani->role);
        $this->assertFalse($petani->is_verified);

        // Step 2: Petani tries to login but is unverified
        $response = $this->withSession([])->post('/login', [
            'email' => 'integration@example.com',
            'password' => 'password123',
            '_token' => csrf_token(),
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');

        // Step 3: Petugas verifies the petani
        $petugas = User::factory()->create(['role' => 'petugas']);

        $this->withSession([])->actingAs($petugas)->post("/petugas/petani/{$petani->id}/verify", [
            '_token' => csrf_token(),
        ]);

        $petani->refresh();
        $this->assertTrue($petani->is_verified);

        // Step 4: Now petani can login successfully
        $response = $this->withSession([])->post('/login', [
            'email' => 'integration@example.com',
            'password' => 'password123',
            '_token' => csrf_token(),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /**
     * Test complete laporan creation and verification flow.
     */
    public function test_complete_laporan_creation_and_verification_flow(): void
    {
        // Setup: Create verified petani and petugas
        $petani = User::factory()->create([
            'role' => 'petani',
            'is_verified' => true,
        ]);

        $petugas = User::factory()->create(['role' => 'petugas']);

        // Step 1: Petani creates laporan
        $response = $this->withSession([])->actingAs($petani)->post('/petani/laporan', [
            'jenis_tanaman' => 'Padi',
            'hasil_panen' => 1500,
            'tanggal_panen' => now()->format('Y-m-d'),
            'luas_lahan' => 2.0,
            'kualitas_panen' => 'Baik',
            'catatan' => 'Panen tahun ini baik',
            '_token' => csrf_token(),
        ]);

        $laporan = Laporan::where('user_id', $petani->id)->first();
        $this->assertNotNull($laporan);
        $this->assertEquals('pending', $laporan->status);

        // Step 2: Petugas views the laporan
        $response = $this->actingAs($petugas)->get('/petugas/laporan');
        $response->assertStatus(200);

        // Step 3: Petugas verifies the laporan
        $this->withSession([])->actingAs($petugas)->post("/petugas/laporan/{$laporan->id}/verify", [
            '_token' => csrf_token(),
        ]);

        $laporan->refresh();
        $this->assertEquals('verified', $laporan->status);

        // Step 4: Petani can see verified status
        $response = $this->actingAs($petani)->get("/petani/laporan/{$laporan->id}");
        $response->assertStatus(200);
    }

    /**
     * Test complete bantuan request and approval flow.
     */
    public function test_complete_bantuan_request_and_approval_flow(): void
    {
        // Setup: Create verified petani and admin
        $petani = User::factory()->create([
            'role' => 'petani',
            'is_verified' => true,
        ]);

        $admin = User::factory()->create(['role' => 'admin']);

        // Step 1: Petani creates bantuan request
        $response = $this->withSession([])->actingAs($petani)->post('/petani/bantuan', [
            'jenis_bantuan' => 'Pupuk Subsidi',
            'jumlah' => 200,
            'tanggal_permintaan' => now()->format('Y-m-d'),
            'keterangan' => 'Membutuhkan pupuk untuk musim tanam',
            '_token' => csrf_token(),
        ]);

        $bantuan = Bantuan::where('user_id', $petani->id)->first();
        $this->assertNotNull($bantuan);
        $this->assertEquals('pending', $bantuan->status);

        // Step 2: Admin views bantuan list
        $response = $this->actingAs($admin)->get('/daftar-bantuan');
        $response->assertStatus(200);

        // Step 3: Petani can view their bantuan status
        $response = $this->actingAs($petani)->get('/petani/bantuan');
        $response->assertStatus(200);
    }

    /**
     * Test role-based access control.
     */
    public function test_role_based_access_control(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $petugas = User::factory()->create(['role' => 'petugas']);
        $petani = User::factory()->create(['role' => 'petani', 'is_verified' => true]);

        // Admin can access admin routes
        $response = $this->actingAs($admin)->get('/admin/berita');
        $response->assertStatus(200);

        // Admin cannot access petugas routes
        $response = $this->actingAs($admin)->get('/petugas/petani');
        $response->assertRedirect('/dashboard');

        // Petugas can access petugas routes
        $response = $this->actingAs($petugas)->get('/petugas/petani');
        $response->assertStatus(200);

        // Petugas cannot access admin routes
        $response = $this->actingAs($petugas)->get('/admin/berita');
        $response->assertRedirect('/dashboard');

        // Petani can access petani routes
        $response = $this->actingAs($petani)->get('/petani/laporan');
        $response->assertStatus(200);

        // Petani cannot access petugas routes
        $response = $this->actingAs($petani)->get('/petugas/petani');
        $response->assertRedirect('/dashboard');
    }

    /**
     * Test multi-user workflow.
     */
    public function test_multi_user_workflow(): void
    {
        // Create multiple users
        $admin = User::factory()->create(['role' => 'admin']);
        $petugas = User::factory()->create(['role' => 'petugas']);
        $petani1 = User::factory()->create(['role' => 'petani', 'is_verified' => false]);
        $petani2 = User::factory()->create(['role' => 'petani', 'is_verified' => false]);

        // Petugas verifies petani1
        $this->withSession([])->actingAs($petugas)->post("/petugas/petani/{$petani1->id}/verify", [
            '_token' => csrf_token(),
        ]);
        $petani1->refresh();
        $this->assertTrue($petani1->is_verified);

        // Petugas rejects petani2
        $this->withSession([])->actingAs($petugas)->delete("/petugas/petani/{$petani2->id}/reject", [
            '_token' => csrf_token(),
        ]);
        $this->assertDatabaseMissing('users', ['id' => $petani2->id]);

        // Verified petani1 creates laporan
        $this->withSession([])->actingAs($petani1)->post('/petani/laporan', [
            'jenis_tanaman' => 'Jagung',
            'hasil_panen' => 800,
            'tanggal_panen' => now()->format('Y-m-d'),
            'luas_lahan' => 1.5,
            '_token' => csrf_token(),
        ]);

        $laporan = Laporan::where('user_id', $petani1->id)->first();
        $this->assertNotNull($laporan);

        // Petugas verifies the laporan
        $this->withSession([])->actingAs($petugas)->post("/petugas/laporan/{$laporan->id}/verify", [
            '_token' => csrf_token(),
        ]);
        $laporan->refresh();
        $this->assertEquals('verified', $laporan->status);

        // Admin can view all data
        $response = $this->actingAs($admin)->get('/hasil-panen');
        $response->assertStatus(200);
    }
}
