<?php

namespace App\Services\SallaService\Services;


use App\Enums\SettingKeysEnum;
use App\Http\Requests\Api\Customer\CreateCustomerRequest;
use App\Services\SallaService\Auth\SallaAuthProviderService;
use App\Services\Setting\SettingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SallaHttpRequestService
{
    private $accessToken = null;

    public function __construct()
    {
        // check token
        $this->isValidToken();
    }

    private function isValidToken(): void
    {
        // check if there is a token in DB
        $setting = (new SettingService())->findByKey(SettingKeysEnum::DEFAULT_ECOMMERCE_CREDENTIALS);
        if ($setting && $setting->value) {
            // check token expiration
            if ($this->checkTokenExpireDate()) {
                $this->accessToken = $setting->value;
            }
            else{
                $this->accessToken = (new SallaAuthProviderService())->handleRefreshTokenRequest($setting);
            }
        }
    }

    public function getStoreInfoDetails()
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->accessToken,
            'Accept' => 'application/json'
        ];
        $url = config('services.salla.salla_url').'/admin/v2/store/info';
        $response = Http::withHeaders($headers)->asForm()->get($url);
        $json_response= json_decode($response->body());
        return $json_response->data;
    }

    public function getProducts()
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->accessToken,
            'Accept' => 'application/json'
        ];
        $url = config('services.salla.salla_url').'/admin/v2/products';
        $response = Http::withHeaders($headers)->asForm()->get($url);
        $json_response= json_decode($response->body());
        return $json_response->data;
    }
    public function getProductDetails(Request $request)
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->accessToken,
            'Accept' => 'application/json'
        ];
        $url = config('services.salla.salla_url').'/admin/v2/products/'.$request->id;
        $response = Http::withHeaders($headers)->asForm()->get($url);
        $json_response= json_decode($response->body());
        return $json_response->data;
    }
    public function createCustomerRequest(CreateCustomerRequest $request)
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->accessToken,
            'Accept' => 'application/json'
        ];
        $url = config('services.salla.salla_url').'/admin/v2/customers';
        $response = Http::withHeaders($headers)->asForm()->post($url, $request->toArray());

        $json_response= json_decode($response->body());
        return $json_response->data;
    }

    public function createOrderRequest(array $orderData)
    {
        $headers = [
            'Authorization' => 'Bearer '.$this->accessToken,
            'Accept' => 'application/json'
        ];
        $url = config('services.salla.salla_url').'/admin/v2/orders';
        $response = Http::withHeaders($headers)->asForm()->post($url, $orderData);

        $json_response= json_decode($response->body());
        return $json_response->data;
    }


    private function checkTokenExpireDate(): bool
    {
        $setting = (new SettingService())->findByKey(SettingKeysEnum::DEFAULT_ECOMMERCE_CREDENTIALS);
        if ($setting && isset($setting->extra['expires_in'])) {
            $expiryTime = Carbon::parse($setting->extra['requested_at'])->addSeconds($setting->extra['expires_in']);
            if($expiryTime->greaterThan(Carbon::now())){
                return true;
            }
        }
        return false;
    }

}
