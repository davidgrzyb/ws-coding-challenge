<?php

namespace App\Http\Controllers;

use App\Inquiry;
use Illuminate\Http\Request;
use App\Mail\InquiryReceived;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CreateInquiryRequest;

class InquiryController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(CreateInquiryRequest $request)
    {
        // Create the Inquiry with the validated data.
        $inquiry = Inquiry::create($request->all());

        // Queue the email notification that will be sent to the configured recipient.
        Mail::to(config('app.notification_recipient.email'))->queue(new InquiryReceived($inquiry));

        // Return a 201 response with the success message.
        return response()->json(['message' => 'Inquiry Created Successfully!'], 201);
    }
}
