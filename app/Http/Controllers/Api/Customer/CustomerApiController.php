<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\CreateCustomerRequest;
use App\Http\Resources\ApiCustomerDetailsResource;
use App\Http\Resources\ApiStoreDetailsResource;
use App\Services\Customer\CustomerService;
use App\Services\Store\StoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerApiController extends Controller
{
    public function create(CreateCustomerRequest $request)
    {
        try {
            return ApiCustomerDetailsResource::make((new CustomerService())->createCustomer($request));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse($exception->getMessage());
        }
    }
}
