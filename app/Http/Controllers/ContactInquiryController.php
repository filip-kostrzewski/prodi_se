<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactInquiryRequest;
use App\Mail\ContactInquiryReceived;
use App\Models\ContactInquiry;
use App\Support\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactInquiryController extends Controller
{
    public function store(StoreContactInquiryRequest $request): RedirectResponse
    {
        $inquiry = ContactInquiry::create([
            ...$request->safe()->only(['name', 'company', 'email', 'phone', 'package', 'message']),
            'locale' => app()->getLocale(),
        ]);

        try {
            Mail::to(Company::contactEmail())->send(new ContactInquiryReceived($inquiry));
        } catch (Throwable $exception) {
            report($exception);

            return back()->withInput()->withErrors([
                'form' => __('site.form.errors.mail_failed', [
                    'email' => Company::contactEmail(),
                ]),
            ]);
        }

        return back()->with('status', __('site.form.success'));
    }
}
