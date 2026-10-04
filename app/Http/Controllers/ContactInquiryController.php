<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactInquiryRequest;
use App\Mail\ContactInquiryReceived;
use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactInquiryController extends Controller
{
    public function store(StoreContactInquiryRequest $request): RedirectResponse
    {
        $inquiry = ContactInquiry::create([
            ...$request->safe()->only(['name', 'company', 'email', 'phone', 'package', 'message']),
            'locale' => app()->getLocale(),
        ]);

        Mail::to((string) config('prodi.contact_email'))->send(new ContactInquiryReceived($inquiry));

        return back()->with('status', __('site.form.success'));
    }
}
