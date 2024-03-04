<?php

namespace App\Http\Controllers\Api\Product;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiProductsListResource;
use App\Http\Resources\ApiStoreDetailsResource;
use App\Services\Product\ProductService;
use App\Services\Store\StoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductApiController extends Controller
{
    public function index()
    {
        try {
            return ApiProductsListResource::collection((new ProductService())->getProductsList());
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse($exception->getMessage());
        }
    }

    public function show(Request $request)
    {
        try {
            return ApiProductsListResource::make((new ProductService())->showProductDetails($request));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse($exception->getMessage());
        }
    }
}
