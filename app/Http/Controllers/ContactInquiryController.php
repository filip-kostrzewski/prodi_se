<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactInquiryRequest;
use App\Mail\ContactInquiryReceived;
use App\Models\ContactInquiry;
use App\Support\Company;
use App\Support\ContactSpamGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactInquiryController extends Controller
{
    public function store(StoreContactInquiryRequest $request, ContactSpamGuard $guard): RedirectResponse
    {
        $data = $request->safe()->only(['name', 'company', 'email', 'phone', 'package', 'message']);
        $ip = $request->ip();

        if ($guard->submittedTooFast($request)) {
            $guard->log('too_fast', $request, $data);

            return $this->thankYou();
        }

        if (! $guard->passesTurnstile($request)) {
            $guard->log('turnstile_failed', $request, ['email' => $data['email'] ?? null]);

            return back()->withInput()->withErrors([
                'form' => __('site.form.errors.verification_failed'),
            ]);
        }

        $spamReason = $guard->blockedReason((string) $data['email'], $ip);

        if ($spamReason === null && ! $guard->looksGenuine($data)) {
            $spamReason = 'ai_not_genuine';
        }

        $inquiry = ContactInquiry::create([
            ...$data,
            'locale' => app()->getLocale(),
            'ip_address' => $ip,
            'spam_reason' => $spamReason,
        ]);

        if ($spamReason !== null) {
            $guard->log($spamReason, $request, ['inquiry_id' => $inquiry->id, 'email' => $inquiry->email]);

            return $this->thankYou();
        }

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

        return $this->thankYou();
    }

    private function thankYou(): RedirectResponse
    {
        return back()->with('status', __('site.form.success'));
    }
}
