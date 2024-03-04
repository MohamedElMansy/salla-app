<?php

namespace App\Enums;


enum SettingKeysEnum: string
{
    case DEFAULT_ECOMMERCE_CREDENTIALS = 'SALLA_CREDENTIALS';

    public static function asArray(): array
    {
        return [
            self::DEFAULT_ECOMMERCE_CREDENTIALS->value => 'Salla Credentials',
        ];
    }
}
