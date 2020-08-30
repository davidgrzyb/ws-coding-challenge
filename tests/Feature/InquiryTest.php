<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
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

    /**
     * Testing the required field validation for the inquiry submission route.
     *
     * @return void
     */
    public function testRequiredFieldValidationForInquiryForm()
    {
        Mail::fake();

        $response = $this->postJson('/api/inquiry/create', [
            'name' => '',
            'email' => '',
            'phone' => '',
            'message' => ''
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'name' => ['The name field is required.'],
                'email' => ['The email field is required.'],
                'phone' => ['The phone field is required.'],
                'message' => ['The message field is required.'],
            ],
        ]);

        $this->assertDatabaseCount('inquiries', 0);

        Mail::assertNothingQueued();
    }

    /**
     * Testing the maximum field length validation for the inquiry submission route.
     *
     * @return void
     */
    public function testMaximumLengthFieldValidationForInquiryForm()
    {
        Mail::fake();

        $response = $this->postJson('/api/inquiry/create', [
            'name' => Str::random(51),
            'email' => Str::random(51),
            'phone' => Str::random(16),
            'message' => Str::random(501),
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'name' => ['The name may not be greater than 50 characters.'],
                'email' => ['The email may not be greater than 50 characters.'],
                'phone' => ['The phone may not be greater than 15 characters.'],
                'message' => ['The message may not be greater than 500 characters.'],
            ],
        ]);

        $this->assertDatabaseCount('inquiries', 0);

        Mail::assertNothingQueued();
    }

    /**
     * Testing the email field validation for the inquiry submission route.
     *
     * @return void
     */
    public function testEmailFieldValidationForInquiryForm()
    {
        Mail::fake();

        $response = $this->postJson('/api/inquiry/create', [
            'name' => 'David Grzyb',
            'email' => 'notanemail',
            'phone' => '1231231234',
            'message' => 'This is a test message.'
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'email' => ['The email must be a valid email address.'],
            ],
        ]);

        $this->assertDatabaseCount('inquiries', 0);

        Mail::assertNothingQueued();
    }

    /**
     * Testing the phone field validation for the inquiry submission route.
     * A phone number cannot be less than 9 characters or more than 15 characters in length.
     *
     * @return void
     */
    public function testPhoneFieldValidationForInquiryForm()
    {
        Mail::fake();

        $response = $this->postJson('/api/inquiry/create', [
            'name' => 'David Grzyb',
            'email' => 'grzybdavid@gmail.com',
            'phone' => '123456789',
            'message' => 'This is a test message.'
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'phone' => ['The phone must be at least 10 characters.'],
            ],
        ]);

        $this->assertDatabaseCount('inquiries', 0);

        $response = $this->postJson('/api/inquiry/create', [
            'name' => 'David Grzyb',
            'email' => 'grzybdavid@gmail.com',
            'phone' => '1234567891234567',
            'message' => 'This is a test message.'
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'phone' => ['The phone may not be greater than 15 characters.'],
            ],
        ]);

        $this->assertDatabaseCount('inquiries', 0);

        Mail::assertNothingQueued();
    }
}
