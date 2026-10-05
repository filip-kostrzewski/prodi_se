<?php

namespace App\Support;

use App\Package;

final class StructuredData
{
    /**
     * @return array<string, mixed>
     */
    public static function forPage(string $title, string $description): array
    {
        $graph = [
            self::organization(),
            self::website(),
            self::webPage($title, $description),
        ];

        if (Locales::currentPage() === 'home') {
            foreach (Package::cases() as $package) {
                $graph[] = self::offer($package);
            }
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private static function organization(): array
    {
        $url = self::baseUrl();
        $address = [
            '@type' => 'PostalAddress',
            'addressLocality' => Company::city(),
            'addressCountry' => 'SE',
        ];

        $street = Company::streetAddress();
        $postalCode = Company::postalCode();

        if ($street !== null) {
            $address['streetAddress'] = $street;
        }

        if ($postalCode !== null) {
            $address['postalCode'] = $postalCode;
        }

        $organization = [
            '@type' => ['Organization', 'LocalBusiness', 'ProfessionalService'],
            '@id' => $url.'/#organization',
            'name' => Company::name(),
            'url' => $url,
            'logo' => $url.'/images/prodi-icon.png',
            'address' => $address,
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Märsta'],
                ['@type' => 'City', 'name' => 'Stockholm'],
                ['@type' => 'City', 'name' => 'Uppsala'],
                ['@type' => 'Country', 'name' => 'Sweden'],
            ],
            'knowsLanguage' => ['sv', 'pl'],
        ];

        $email = Company::publishedContactEmail();

        if ($email !== null) {
            $organization['email'] = $email;
        }

        $orgNumber = Company::orgNumber();

        if ($orgNumber !== null) {
            $organization['taxID'] = $orgNumber;
        }

        return $organization;
    }

    /**
     * @return array<string, mixed>
     */
    private static function website(): array
    {
        $url = self::baseUrl();

        return [
            '@type' => 'WebSite',
            '@id' => $url.'/#website',
            'url' => $url,
            'name' => Company::name(),
            'publisher' => ['@id' => $url.'/#organization'],
            'inLanguage' => Locales::codes(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private static function webPage(string $title, string $description): array
    {
        $url = self::baseUrl();
        $canonical = url()->current();

        return [
            '@type' => 'WebPage',
            '@id' => $canonical.'#webpage',
            'url' => $canonical,
            'name' => $title,
            'description' => $description,
            'inLanguage' => app()->getLocale(),
            'isPartOf' => ['@id' => $url.'/#website'],
            'about' => ['@id' => $url.'/#organization'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private static function offer(Package $package): array
    {
        $offer = [
            '@type' => 'Offer',
            'name' => $package->label(),
            'description' => (string) __('site.packages.schema.'.$package->value),
            'url' => Locales::urlFor('home', app()->getLocale()).'#packages',
            'priceCurrency' => 'SEK',
            'availability' => 'https://schema.org/InStock',
            'seller' => ['@id' => self::baseUrl().'/#organization'],
            'priceSpecification' => self::priceSpecification($package),
        ];

        if (! $package->isFromPrice()) {
            $offer['price'] = $package->priceAmount();
        }

        return $offer;
    }

    /**
     * @return array<string, mixed>
     */
    private static function priceSpecification(Package $package): array
    {
        if ($package->isFromPrice()) {
            return [
                '@type' => 'PriceSpecification',
                'minPrice' => $package->priceAmount(),
                'priceCurrency' => 'SEK',
                'valueAddedTaxIncluded' => false,
            ];
        }

        if ($package->isMonthly()) {
            return [
                '@type' => 'UnitPriceSpecification',
                'price' => $package->priceAmount(),
                'priceCurrency' => 'SEK',
                'valueAddedTaxIncluded' => false,
                'unitText' => 'MON',
                'referenceQuantity' => [
                    '@type' => 'QuantitativeValue',
                    'value' => 1,
                    'unitCode' => 'MON',
                ],
            ];
        }

        return [
            '@type' => 'PriceSpecification',
            'price' => $package->priceAmount(),
            'priceCurrency' => 'SEK',
            'valueAddedTaxIncluded' => false,
        ];
    }

    private static function baseUrl(): string
    {
        return rtrim((string) config('app.url'), '/');
    }
}
