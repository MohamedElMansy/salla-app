<?php

namespace App\Services\SallaService\Auth;


use App\Enums\SettingKeysEnum;
use App\Services\Setting\SettingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SallaAuthHttpRequestService
{
    public function prepareAuthRequest()
    {
        $clientID = config('services.salla.client_id');
        $clientSecret = config('services.salla.client_secret');
        $callbackUrl=config('services.salla.callback_url');
        $data = [
            'state' => rand(11111111,99999999),
            'client_id' => $clientID,
            'client_secret' => $clientSecret,
            'redirect_uri' => $callbackUrl,
            'scope' => 'offline_access',
            'response_type' => 'code'
        ];

        $queryString = http_build_query($data);

        $url = config('services.salla.auth_url') . '?' . $queryString;
        return $url;
    }
    public function sendTokenRequest(Request $request)
    {
        $clientID = config('services.salla.client_id');
        $clientSecret = config('services.salla.client_secret');
        $callbackUrl=config('services.salla.callback_url');
        $data = [
            'state' => $request->state,
            'client_id' => $clientID,
            'client_secret' => $clientSecret,
            'redirect_uri' => $callbackUrl,
            'scope' => 'offline_access',
            'grant_type' => 'authorization_code',
            'code'=>$request->code
        ];
        $headers = [
            'Accept' => 'application/json'
        ];

        $url = config('services.salla.token_url');
        $response = Http::withHeaders($headers)->asForm()->post($url, $data);
        $json_response= json_decode($response->body());
        return $json_response;
    }
    public function getNewAccessToken($refreshToken)
    {
        $clientID = config('services.salla.client_id');
        $clientSecret = config('services.salla.client_secret');
        $data = [
            'client_id' => $clientID,
            'client_secret' => $clientSecret,
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token'
        ];
        $headers = [
            'Accept' => 'application/json'
        ];

        $url = config('services.salla.token_url');
        $response = Http::withHeaders($headers)->asForm()->post($url, $data);
        $json_response= json_decode($response->body());
        return $json_response;
    }
}
