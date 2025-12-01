<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Test login page can be displayed.
     */
    public function test_login_page_can_be_displayed(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /**
     * Test user can login with valid credentials.
     */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->verified()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'petani',
        ]);

        $response = $this->withoutMiddleware()->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /**
     * Test user cannot login with invalid credentials.
     */
    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->verified()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->withoutMiddleware()->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }

    /**
     * Test admin redirected to dashboard after login.
     */
    public function test_admin_redirected_to_dashboard_after_login(): void
    {
        $admin = User::factory()->verified()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $response = $this->withoutMiddleware()->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /**
     * Test petugas redirected to dashboard after login.
     */
    public function test_petugas_redirected_to_dashboard_after_login(): void
    {
        $petugas = User::factory()->verified()->create([
            'email' => 'petugas@example.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        $response = $this->withoutMiddleware()->post('/login', [
            'email' => 'petugas@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /**
     * Test petani redirected to dashboard after login.
     */
    public function test_petani_redirected_to_dashboard_after_login(): void
    {
        $petani = User::factory()->verified()->create([
            'email' => 'petani@example.com',
            'password' => Hash::make('password'),
            'role' => 'petani',
        ]);

        $response = $this->withoutMiddleware()->post('/login', [
            'email' => 'petani@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /**
     * Test unverified petani cannot login.
     */
    public function test_unverified_petani_cannot_login(): void
    {
        $petani = User::factory()->unverified()->create([
            'email' => 'petani@example.com',
            'password' => Hash::make('password'),
            'role' => 'petani',
        ]);

        $response = $this->withoutMiddleware()->post('/login', [
            'email' => 'petani@example.com',
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /**
     * Test authenticated user cannot access login page.
     */
    public function test_authenticated_user_cannot_access_login_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/dashboard');
    }

    /**
     * Test user can logout.
     */
    public function test_user_can_logout(): void
    {
        $user = User::factory()->verified()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($user);
        $this->assertAuthenticated();

        $response = $this->withoutMiddleware()->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    /**
     * Test login requires email.
     */
    public function test_login_requires_email(): void
    {
        $response = $this->withoutMiddleware()->post('/login', [
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test login requires password.
     */
    public function test_login_requires_password(): void
    {
        $response = $this->withoutMiddleware()->post('/login', [
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test login requires valid email format.
     */
    public function test_login_requires_valid_email_format(): void
    {
        $response = $this->withoutMiddleware()->post('/login', [
            'email' => 'not-an-email',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
