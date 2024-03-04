<?php

namespace App\Services\Ecommerce\Auth;

use App\Constants\SystemConstants;
use App\Enums\Ecommerce\EcommerceProviderEnum;
use App\Enums\SettingKeysEnum;
use App\Services\SallaService\Auth\SallaAuthProviderService;
use App\Services\Setting\SettingService;
use Illuminate\Http\Request;

class EcommerceAuthService
{

    public function sendAuthRequest()
    {
        $ecommerceProvider = $this->getEcommerceAuthProvider(SystemConstants::DEFAULT_GOVERNMENT_PROVIDER);
        return $ecommerceProvider->sendAuthRequest();

    }
    public function handleCallbackRequest(Request $request)
    {
        $ecommerceProvider = $this->getEcommerceAuthProvider(SystemConstants::DEFAULT_GOVERNMENT_PROVIDER);
        $response=$ecommerceProvider->handleCallbackRequest($request);
        $response->requested_at=now();
        (new SettingService())->createSetting('Ecommerce Access Token',SettingKeysEnum::DEFAULT_ECOMMERCE_CREDENTIALS,$response->access_token,$response);

    }
    public function getEcommerceAuthProvider(EcommerceProviderEnum $ecommerceProviderEnum)
    {
        return match ($ecommerceProviderEnum->value) {
            EcommerceProviderEnum::SALLA->value => new SallaAuthProviderService(),
            default => throw new \Exception('No Ecommerce Provider Found')
        };
    }
}
