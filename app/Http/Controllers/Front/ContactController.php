<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Responses\ContactPageResponse;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * 2.4 Contact Page
     * - Show contact form
     */
    public function showForm(Request $request): ContactPageResponse
    {
        return new ContactPageResponse(
            statusMessage: session('status')
        );
    }

    /**
     * Store contact message in DB
     * - Admin will see these in the dashboard
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create($data);

        return redirect()
            ->route('contact.form')
            ->with('status', 'Your message has been sent successfully.');
    }
}
