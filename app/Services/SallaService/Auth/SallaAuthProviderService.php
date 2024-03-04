<?php

namespace App\Services\SallaService\Auth;

use App\Enums\SettingKeysEnum;
use App\Interfaces\Ecommerce\Auth\EcommerceAuthProviderInterface;
use App\Models\Setting;
use App\Services\Setting\SettingService;
use Illuminate\Http\Request;

class SallaAuthProviderService extends SallaAuthHttpRequestService implements EcommerceAuthProviderInterface
{

    public function sendAuthRequest()
    {
        return $this->prepareAuthRequest();
    }

    public function handleCallbackRequest(Request $request)
    {
        return $this->sendTokenRequest($request);
    }
    public function handleRefreshTokenRequest(Setting $setting)
    {
        $refresh_token=$setting->extra['refresh_token'];
        if ($refresh_token){
            $response=$this->getNewAccessToken($refresh_token);
            $response->requested_at=now();
            (new SettingService())->createSetting('Ecommerce Access Token',SettingKeysEnum::DEFAULT_ECOMMERCE_CREDENTIALS,$response->access_token,$response);
            return $response->access_token;
        }
    }
}
