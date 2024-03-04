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
    private function sendRequest($method, $url, $data = [])
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Accept' => 'application/json'
        ];

        $response = Http::withHeaders($headers)->asForm()->{$method}($url, $data);
        $json_response = json_decode($response->body());
        $status_code = $response->status();

        if ($status_code == 200) {
            return $json_response->data;
        } else {
            throw new \Exception('Invalid response Code ' . $status_code . ' || ' . $response->body().' for Api '.$url);
        }
    }

    public function getStoreInfoDetails()
    {
        $url = config('services.salla.salla_url') . '/admin/v2/store/info';
        return $this->sendRequest('get', $url);
    }

    public function getProducts()
    {
        $url = config('services.salla.salla_url') . '/admin/v2/products';
        return $this->sendRequest('get', $url);
    }

    public function getProductDetails(Request $request)
    {
        $url = config('services.salla.salla_url') . '/admin/v2/products/' . $request->id;
        return $this->sendRequest('get', $url);
    }

    public function createCustomerRequest(CreateCustomerRequest $request)
    {
        $url = config('services.salla.salla_url') . '/admin/v2/customers';
        return $this->sendRequest('post', $url, $request->toArray());
    }

    public function createOrderRequest(array $orderData)
    {
        $url = config('services.salla.salla_url') . '/admin/v2/orders';
        return $this->sendRequest('post', $url, $orderData);
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
