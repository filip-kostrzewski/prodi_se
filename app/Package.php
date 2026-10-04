<?php

namespace App;

enum Package: string
{
    case Start = 'start';
    case Firma = 'firma';
    case Opieka = 'opieka';
    case Individual = 'individual';

    public function label(): string
    {
        return (string) __('site.packages.names.'.$this->value);
    }

    public function optionLabel(): string
    {
        return (string) __('site.form.package_options.'.$this->value);
    }

    public function priceAmount(): int
    {
        return match ($this) {
            self::Start => 4900,
            self::Firma => 7900,
            self::Opieka => 299,
            self::Individual => 9900,
        };
    }

    public function isMonthly(): bool
    {
        return $this === self::Opieka;
    }

    public function isFromPrice(): bool
    {
        return $this === self::Individual;
    }
}
