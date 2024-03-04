<?php

namespace App\Enums\Ecommerce;

enum EcommerceProviderEnum: int
{
    case SALLA = 1;

    public static function asArray(): array
    {
        return [
            self::SALLA->value => 'Salla',
        ];
    }
}
