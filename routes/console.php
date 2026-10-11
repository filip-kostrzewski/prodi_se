<?php

use App\Support\ContactSpamGuard;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('contact:check-spam {--name=} {--company=} {--email=} {--package=firma} {--message=}', function (ContactSpamGuard $guard) {
    if (! ContactSpamGuard::aiEnabled()) {
        $this->warn('AI check is off (no API key for provider ['.config('contact.ai.provider').']). Every inquiry would be e-mailed.');

        return 1;
    }

    $inquiry = [
        'name' => (string) $this->option('name'),
        'company' => (string) $this->option('company'),
        'email' => (string) $this->option('email'),
        'phone' => '',
        'package' => (string) $this->option('package'),
        'message' => (string) $this->option('message'),
    ];

    try {
        $genuine = $guard->askAi($inquiry);
    } catch (Throwable $exception) {
        $this->error('AI call failed ('.class_basename($exception).'): '.$exception->getMessage());
        $this->line('On the live form this inquiry would be e-mailed (fail-open).');

        return 1;
    }

    $this->line('Provider: '.config('contact.ai.provider').', model: '.(config('contact.ai.model') ?: 'provider default'));
    $this->line($genuine ? 'YES: genuine inquiry, would be e-mailed.' : 'NO: held back as spam, not e-mailed.');

    return 0;
})->purpose('Ask the AI whether a contact form text is a genuine inquiry (nothing is saved or sent)');
