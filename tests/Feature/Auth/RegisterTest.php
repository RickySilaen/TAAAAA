<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * Test registration page can be displayed.
     */
    public function test_registration_page_can_be_displayed(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /**
     * Test user can register as petani.
     */
    public function test_user_can_register_as_petani(): void
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Test Petani',
            'email' => 'petani@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'alamat_desa' => 'Desa Test',
            'alamat_kecamatan' => 'Kecamatan Test',
            'luas_lahan' => 1.5,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'petani@example.com',
            'role' => 'petani',
            'is_verified' => false,
        ]);

        $user = User::where('email', 'petani@example.com')->first();
        $this->assertEquals('petani', $user->role);
        $this->assertFalse($user->is_verified);
    }

    /**
     * Test registration requires name.
     */
    public function test_registration_requires_name(): void
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test registration requires email.
     */
    public function test_registration_requires_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test registration requires valid email.
     */
    public function test_registration_requires_valid_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'not-an-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test registration requires unique email.
     */
    public function test_registration_requires_unique_email(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test registration requires password.
     */
    public function test_registration_requires_password(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test registration requires password confirmation.
     */
    public function test_registration_requires_password_confirmation(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test registration requires minimum password length.
     */
    public function test_registration_requires_minimum_password_length(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test password is hashed after registration.
     */
    public function test_password_is_hashed_after_registration(): void
    {
        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $this->assertNotEquals('password123', $user->password);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /**
     * Test authenticated user cannot access registration page.
     */
    public function test_authenticated_user_cannot_access_registration_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect('/dashboard');
    }

    /**
     * Test new petani is not verified by default.
     */
    public function test_new_petani_is_not_verified_by_default(): void
    {
        $this->post('/register', [
            'name' => 'Test Petani',
            'email' => 'petani@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'petani@example.com')->first();

        $this->assertFalse($user->is_verified);
    }

    /**
     * Test registration stores alamat desa and kecamatan.
     */
    public function test_registration_stores_alamat_desa_and_kecamatan(): void
    {
        $this->post('/register', [
            'name' => 'Test Petani',
            'email' => 'petani@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'alamat_desa' => 'Desa Sejahtera',
            'alamat_kecamatan' => 'Kecamatan Makmur',
            'luas_lahan' => 2.5,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'petani@example.com',
            'alamat_desa' => 'Desa Sejahtera',
            'alamat_kecamatan' => 'Kecamatan Makmur',
            'luas_lahan' => 2.5,
        ]);
    }
}
