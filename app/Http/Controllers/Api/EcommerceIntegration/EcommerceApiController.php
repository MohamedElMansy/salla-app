<?php

namespace App\Http\Controllers\Api\EcommerceIntegration;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\Ecommerce\Auth\EcommerceAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EcommerceApiController extends Controller
{
    //get the login url for give the app permission and get the access token
    public function sendAuthRequest(Request $request)
    {
        try {
            return ResponseHelper::successResponse([
                'Login_URL' => (new EcommerceAuthService())->sendAuthRequest()
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse($exception->getMessage());
        }
    }
    //handle the callback request from ecommerce (Salla) which contains access token.
    public function callback(Request $request)
    {
        try {
            (new EcommerceAuthService())->handleCallbackRequest($request);
            return ResponseHelper::successResponse([
                'message' => "Integrated Successfully with Salla"
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse($exception->getMessage());
        }
    }
}
