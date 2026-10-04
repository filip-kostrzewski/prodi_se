<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Reads company facts from config. Legal identifiers stay empty until the owner fills them in.
 */
final class Company
{
    public static function name(): string
    {
        return (string) config('prodi.name');
    }

    public static function owner(): string
    {
        return (string) config('prodi.owner');
    }

    public static function city(): string
    {
        return (string) config('prodi.city');
    }

    public static function contactEmail(): string
    {
        return (string) config('prodi.contact_email');
    }

    /**
     * Address shown to visitors. Example domains stay in config for local mail, and are not published.
     */
    public static function publishedContactEmail(): ?string
    {
        $email = self::contactEmail();

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        $host = Str::lower(Str::after($email, '@'));

        if (in_array($host, ['example.com', 'example.org', 'example.net'], true)) {
            return null;
        }

        return $email;
    }

    public static function orgNumber(): ?string
    {
        return self::filled('org_number');
    }

    public static function streetAddress(): ?string
    {
        return self::filled('street_address');
    }

    public static function postalCode(): ?string
    {
        return self::filled('postal_code');
    }

    /**
     * Street and postal code only. The city is already known and shown separately.
     */
    public static function streetLine(): ?string
    {
        $parts = array_values(array_filter([
            self::streetAddress(),
            self::postalCode(),
        ]));

        if ($parts === []) {
            return null;
        }

        return implode(' ', $parts);
    }

    private static function filled(string $key): ?string
    {
        $value = config('prodi.'.$key);

        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }
}
