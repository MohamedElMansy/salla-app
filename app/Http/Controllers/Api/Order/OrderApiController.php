<?php

namespace App\Http\Controllers\Api\Order;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\CreateOrderRequest;
use App\Services\Order\OrderService;
use Illuminate\Support\Facades\Log;

class OrderApiController extends Controller
{
    public function create(CreateOrderRequest $request)
    {
        try {
            (new OrderService())->addOrderToQueue($request);
            return ResponseHelper::successResponse([
                'message' => "Order queued for processing"
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse($exception->getMessage());
        }
    }
}
