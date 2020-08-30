<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Mail\InquiryReceived;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InquiryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A test of the basic inquiry submission process.
     *
     * @return void
     */
    public function testSuccessfulSubmissionOfInquiry()
    {
        Mail::fake();

        // Send response.
        $response = $this->postJson('/api/inquiry/create', [
            'name' => 'David Grzyb',
            'email' => 'grzybdavid@gmail.com',
            'phone' => '1231231234',
            'message' => 'This is a test message.'
        ]);

        // Assert the correct response was received back.
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Inquiry Created Successfully!',
            ]);

        // Assert the record was created in the database.
        $this->assertDatabaseHas('inquiries', [
            'name' => 'David Grzyb',
            'email' => 'grzybdavid@gmail.com',
            'phone' => '1231231234',
            'message' => 'This is a test message.'
        ]);

        // Assert the email notification was sent.
        Mail::assertQueued(function (InquiryReceived $mail) {
            return $mail->hasTo(config('app.notification_recipient.email')) &&
                $mail->inquiry->name === 'David Grzyb' &&
                $mail->inquiry->email === 'grzybdavid@gmail.com' &&
                $mail->inquiry->phone === '1231231234' &&
                $mail->inquiry->message === 'This is a test message.';
        });
    }
}
