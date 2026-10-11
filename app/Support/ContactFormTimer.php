<?php

namespace App\Support;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class ContactFormTimer
{
    public const FIELD = 'form_started';

    /**
     * Encrypted timestamp rendered into the form.
     */
    public static function issue(): string
    {
        return Crypt::encryptString((string) now()->getTimestamp());
    }

    /**
     * Seconds since the form was rendered, or null when the field is missing or not ours.
     */
    public static function elapsedSeconds(mixed $token): ?int
    {
        if (! is_string($token) || $token === '') {
            return null;
        }

        try {
            $issuedAt = Crypt::decryptString($token);
        } catch (DecryptException) {
            return null;
        }

        if (! ctype_digit($issuedAt)) {
            return null;
        }

        return now()->getTimestamp() - (int) $issuedAt;
    }
}
