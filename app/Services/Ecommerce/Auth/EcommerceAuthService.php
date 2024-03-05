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
        // Get the default ecommerce service provider (in case there is more one platform)
        $ecommerceProvider = $this->getEcommerceAuthProvider(SystemConstants::DEFAULT_GOVERNMENT_PROVIDER);
        return $ecommerceProvider->sendAuthRequest();

    }
    //Handle the request returned from ecommerce service provider(Salla) to get access token
    public function handleCallbackRequest(Request $request)
    {
        $ecommerceProvider = $this->getEcommerceAuthProvider(SystemConstants::DEFAULT_GOVERNMENT_PROVIDER);
        $response=$ecommerceProvider->handleCallbackRequest($request);
        $response->requested_at=now();
        // Save the access token and the response in the setting
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
