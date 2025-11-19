<?php

namespace Tests\Unit;

use App\Models\Feedback;
use Tests\TestCase;

class FeedbackModelTest extends TestCase
{
    /**
     * Test feedback can be created with valid attributes.
     */
    public function test_feedback_can_be_created(): void
    {
        $feedback = Feedback::create([
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'subjek' => 'Test Feedback',
            'pesan' => 'Ini adalah pesan test feedback',
            'status' => 'unread',
        ]);

        $this->assertDatabaseHas('feedbacks', [
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'subjek' => 'Test Feedback',
        ]);

        $this->assertEquals('John Doe', $feedback->nama);
        $this->assertEquals('unread', $feedback->status);
    }

    /**
     * Test feedback status can be updated.
     */
    public function test_feedback_status_can_be_updated(): void
    {
        $feedback = Feedback::create([
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'subjek' => 'Test',
            'pesan' => 'Test pesan',
            'status' => 'unread',
        ]);

        $this->assertEquals('unread', $feedback->status);

        $feedback->update(['status' => 'read']);

        $this->assertEquals('read', $feedback->fresh()->status);
    }

    /**
     * Test feedback fillable attributes.
     */
    public function test_feedback_fillable_attributes(): void
    {
        $feedback = new Feedback();
        $fillable = $feedback->getFillable();

        $this->assertContains('nama', $fillable);
        $this->assertContains('email', $fillable);
        $this->assertContains('subjek', $fillable);
        $this->assertContains('pesan', $fillable);
        $this->assertContains('status', $fillable);
    }

    /**
     * Test feedback can be deleted.
     */
    public function test_feedback_can_be_deleted(): void
    {
        $feedback = Feedback::create([
            'nama' => 'Test User',
            'email' => 'test@example.com',
            'subjek' => 'Test',
            'pesan' => 'Test pesan',
        ]);

        $feedbackId = $feedback->id;

        $feedback->delete();

        $this->assertDatabaseMissing('feedbacks', [
            'id' => $feedbackId,
        ]);
    }
}
