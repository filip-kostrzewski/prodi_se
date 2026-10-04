<?php

namespace App\Support;

/**
 * Public languages for the site.
 *
 * Swedish is the default and lives at /. Other languages use a URL prefix.
 * To add English later: append a row here, add the paths below, and create lang/en/site.php.
 */
final class Locales
{
    public const DEFAULT = 'sv';

    /**
     * @var array<string, array{prefix: string, hreflang: string, og: string, label: string, name: string}>
     */
    public const DEFINITIONS = [
        'sv' => [
            'prefix' => '',
            'hreflang' => 'sv',
            'og' => 'sv_SE',
            'label' => 'SV',
            'name' => 'Svenska',
        ],
        'pl' => [
            'prefix' => 'pl',
            'hreflang' => 'pl',
            'og' => 'pl_PL',
            'label' => 'PL',
            'name' => 'Polski',
        ],
    ];

    /**
     * Path relative to the locale prefix. "/" is the locale root.
     *
     * @var array<string, array<string, string>>
     */
    public const PATHS = [
        'home' => [
            'sv' => '/',
            'pl' => '/',
        ],
        'contact' => [
            'sv' => 'kontakt',
            'pl' => 'kontakt',
        ],
        'privacy' => [
            'sv' => 'integritet',
            'pl' => 'prywatnosc',
        ],
        'example.cleaning' => [
            'sv' => 'exempel/stadning',
            'pl' => 'przyklady/sprzatanie',
        ],
        'example.painting' => [
            'sv' => 'exempel/malning',
            'pl' => 'przyklady/malowanie',
        ],
        'example.painting.services' => [
            'sv' => 'exempel/malning/tjanster',
            'pl' => 'przyklady/malowanie/uslugi',
        ],
        'example.painting.gallery' => [
            'sv' => 'exempel/malning/galleri',
            'pl' => 'przyklady/malowanie/galeria',
        ],
        'example.painting.contact' => [
            'sv' => 'exempel/malning/kontakt',
            'pl' => 'przyklady/malowanie/kontakt',
        ],
    ];

    /**
     * @return list<string>
     */
    public static function codes(): array
    {
        return array_keys(self::DEFINITIONS);
    }

    public static function supports(string $locale): bool
    {
        return array_key_exists($locale, self::DEFINITIONS);
    }

    public static function uri(string $page, string $locale): string
    {
        return self::PATHS[$page][$locale];
    }

    public static function urlFor(string $page, string $locale): string
    {
        return route($locale.'.'.$page);
    }

    public static function currentPage(): ?string
    {
        $name = request()->route()?->getName();

        if (! is_string($name) || ! str_contains($name, '.')) {
            return null;
        }

        $locale = strstr($name, '.', true);

        if (! is_string($locale) || ! self::supports($locale)) {
            return null;
        }

        return substr($name, strlen($locale) + 1);
    }

    /**
     * @return array<string, string>
     */
    public static function alternateUrls(): array
    {
        $page = self::currentPage() ?? 'home';
        $urls = [];

        foreach (self::codes() as $locale) {
            $urls[$locale] = self::urlFor($page, $locale);
        }

        return $urls;
    }
}
