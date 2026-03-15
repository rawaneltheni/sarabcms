<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc,dns', 'max:190'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ]);

        return redirect()
            ->route('contact-us')
            ->with('contact_success', 'Thanks! Your request has been received. Our team will contact you soon.');
    }
}
