<?php

namespace App\Services\Ecommerce\Services;

use App\Constants\SystemConstants;
use App\Enums\Ecommerce\EcommerceProviderEnum;
use App\Enums\SettingKeysEnum;
use App\Services\SallaService\Auth\SallaAuthProviderService;
use App\Services\SallaService\Services\SallaProviderService;
use App\Services\Setting\SettingService;
use Illuminate\Http\Request;

class EcommerceService
{
    public function getEcommerceProvider(EcommerceProviderEnum $ecommerceProviderEnum)
    {
        return match ($ecommerceProviderEnum->value) {
            EcommerceProviderEnum::SALLA->value => new SallaProviderService(),
            default => throw new \Exception('No Ecommerce Provider Found')
        };
    }
}
