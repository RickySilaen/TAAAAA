<?php

namespace Tests\Feature\Guest;

use App\Models\Berita;
use App\Models\Feedback;
use App\Models\Newsletter;
use Tests\TestCase;

class GuestControllerTest extends TestCase
{
    /**
     * Test guest can view homepage.
     */
    public function test_guest_can_view_homepage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('index');
    }

    /**
     * Test guest can view tentang page.
     */
    public function test_guest_can_view_tentang_page(): void
    {
        $response = $this->get('/tentang');

        $response->assertStatus(200);
        $response->assertViewIs('guest.tentang');
    }

    /**
     * Test guest can view kontak page.
     */
    public function test_guest_can_view_kontak_page(): void
    {
        $response = $this->get('/kontak');

        $response->assertStatus(200);
        $response->assertViewIs('guest.kontak');
    }

    /**
     * Test guest can view berita page.
     */
    public function test_guest_can_view_berita_page(): void
    {
        $response = $this->get('/berita');

        $response->assertStatus(200);
        $response->assertViewIs('guest.berita');
    }

    /**
     * Test guest can view berita detail.
     */
    public function test_guest_can_view_berita_detail(): void
    {
        $berita = Berita::create([
            'judul' => 'Test Berita',
            'slug' => 'test-berita',
            'konten' => 'Test konten berita',
            'status' => 'published',
        ]);

        $response = $this->get("/berita/{$berita->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('guest.berita-detail');
        $response->assertSeeText('Test Berita');
    }

    /**
     * Test guest can view galeri page.
     */
    public function test_guest_can_view_galeri_page(): void
    {
        $response = $this->get('/galeri');

        $response->assertStatus(200);
        $response->assertViewIs('guest.galeri');
    }

    /**
     * Test guest can subscribe to newsletter.
     */
    public function test_guest_can_subscribe_to_newsletter(): void
    {
        $response = $this->post('/newsletter/subscribe', [
            'email' => 'subscriber@example.com',
        ]);

        $this->assertDatabaseHas('newsletters', [
            'email' => 'subscriber@example.com',
            'status' => 'active',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /**
     * Test guest cannot subscribe with duplicate email.
     */
    public function test_guest_cannot_subscribe_with_duplicate_email(): void
    {
        Newsletter::create([
            'email' => 'existing@example.com',
            'status' => 'active',
        ]);

        $response = $this->post('/newsletter/subscribe', [
            'email' => 'existing@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test guest can submit feedback.
     */
    public function test_guest_can_submit_feedback(): void
    {
        $response = $this->post('/feedback', [
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'subjek' => 'Test Feedback',
            'pesan' => 'Ini adalah pesan feedback test',
        ]);

        $this->assertDatabaseHas('feedbacks', [
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'subjek' => 'Test Feedback',
            'status' => 'unread',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /**
     * Test feedback requires nama.
     */
    public function test_feedback_requires_nama(): void
    {
        $response = $this->post('/feedback', [
            'email' => 'john@example.com',
            'subjek' => 'Test',
            'pesan' => 'Test pesan',
        ]);

        $response->assertSessionHasErrors('nama');
    }

    /**
     * Test feedback requires email.
     */
    public function test_feedback_requires_email(): void
    {
        $response = $this->post('/feedback', [
            'nama' => 'John Doe',
            'subjek' => 'Test',
            'pesan' => 'Test pesan',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test feedback requires valid email.
     */
    public function test_feedback_requires_valid_email(): void
    {
        $response = $this->post('/feedback', [
            'nama' => 'John Doe',
            'email' => 'not-an-email',
            'subjek' => 'Test',
            'pesan' => 'Test pesan',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test feedback requires subjek.
     */
    public function test_feedback_requires_subjek(): void
    {
        $response = $this->post('/feedback', [
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'pesan' => 'Test pesan',
        ]);

        $response->assertSessionHasErrors('subjek');
    }

    /**
     * Test feedback requires pesan.
     */
    public function test_feedback_requires_pesan(): void
    {
        $response = $this->post('/feedback', [
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'subjek' => 'Test',
        ]);

        $response->assertSessionHasErrors('pesan');
    }

    /**
     * Test newsletter subscription requires email.
     */
    public function test_newsletter_subscription_requires_email(): void
    {
        $response = $this->post('/newsletter/subscribe', []);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test newsletter subscription requires valid email.
     */
    public function test_newsletter_subscription_requires_valid_email(): void
    {
        $response = $this->post('/newsletter/subscribe', [
            'email' => 'not-an-email',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
