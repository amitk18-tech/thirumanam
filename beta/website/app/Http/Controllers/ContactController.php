<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        // Send email notification to admin
        try {
            Mail::raw(
                "Name: {$request->name}\nEmail: {$request->email}\nSubject: {$request->subject}\n\nMessage:\n{$request->message}",
                function ($mail) use ($request) {
                    $mail->to('service@thirumanam.info')
                         ->subject('Contact Form: ' . $request->subject)
                         ->replyTo($request->email, $request->name);
                }
            );
            return redirect('/contact')->with('contact_success', 'Thank you! Your message has been sent. We will get back to you shortly.');
        } catch (\Exception $e) {
            return redirect('/contact')->with('contact_error', 'Sorry, we could not send your message. Please try again or email us directly.');
        }
    }
}
