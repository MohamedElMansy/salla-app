<?php

namespace App\Http\Controllers\Api\Store;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiStoreDetailsResource;
use App\Services\Store\StoreService;
use Illuminate\Support\Facades\Log;

class StoreApiController extends Controller
{
    public function getStoreDetails()
    {
        try {
            return ApiStoreDetailsResource::make((new StoreService())->getStoreDetails());
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse($exception->getMessage());
        }
    }
}
