<?php

namespace Tests\Unit;

use App\Models\Newsletter;
use Tests\TestCase;

class NewsletterModelTest extends TestCase
{
    /**
     * Test newsletter can be created with valid attributes.
     */
    public function test_newsletter_can_be_created(): void
    {
        $newsletter = Newsletter::create([
            'email' => 'subscriber@example.com',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('newsletters', [
            'email' => 'subscriber@example.com',
            'status' => 'active',
        ]);

        $this->assertEquals('subscriber@example.com', $newsletter->email);
        $this->assertEquals('active', $newsletter->status);
    }

    /**
     * Test newsletter email must be unique.
     */
    public function test_newsletter_email_must_be_unique(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Newsletter::create(['email' => 'duplicate@example.com', 'status' => 'active']);
        Newsletter::create(['email' => 'duplicate@example.com', 'status' => 'active']);
    }

    /**
     * Test newsletter status can be active or unsubscribed.
     */
    public function test_newsletter_status_can_be_active_or_unsubscribed(): void
    {
        $activeNewsletter = Newsletter::create([
            'email' => 'active@example.com',
            'status' => 'active',
        ]);

        $unsubscribedNewsletter = Newsletter::create([
            'email' => 'unsubscribed@example.com',
            'status' => 'unsubscribed',
        ]);

        $this->assertEquals('active', $activeNewsletter->status);
        $this->assertEquals('unsubscribed', $unsubscribedNewsletter->status);
    }

    /**
     * Test newsletter fillable attributes.
     */
    public function test_newsletter_fillable_attributes(): void
    {
        $newsletter = new Newsletter();
        $fillable = $newsletter->getFillable();

        $this->assertContains('email', $fillable);
        $this->assertContains('status', $fillable);
    }

    /**
     * Test newsletter can be deleted.
     */
    public function test_newsletter_can_be_deleted(): void
    {
        $newsletter = Newsletter::create([
            'email' => 'delete@example.com',
            'status' => 'active',
        ]);

        $newsletterId = $newsletter->id;

        $newsletter->delete();

        $this->assertDatabaseMissing('newsletters', [
            'id' => $newsletterId,
        ]);
    }
}
