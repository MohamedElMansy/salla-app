<?php

namespace App\Services\Order;


use App\Constants\SystemConstants;
use App\Http\Requests\Api\Order\CreateOrderRequest;
use App\Jobs\ProcessCreateOrder;
use App\Services\Ecommerce\Services\EcommerceService;

class OrderService
{
    public function addOrderToQueue(CreateOrderRequest $request)
    {
        ProcessCreateOrder::dispatch($request->toArray())->onQueue('order_creation');
    }

    public function createOrder(array $orderData)
    {
        $ecommerceProvider =  (new EcommerceService())->getEcommerceProvider(SystemConstants::DEFAULT_GOVERNMENT_PROVIDER);
        return $ecommerceProvider->createOrder($orderData);
    }
}
