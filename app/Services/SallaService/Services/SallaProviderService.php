<?php

namespace App\Services\SallaService\Services;

use App\Http\Requests\Api\Customer\CreateCustomerRequest;
use App\Interfaces\Ecommerce\EcommerceProviderInterface;
use Illuminate\Http\Request;

class SallaProviderService extends SallaHttpRequestService implements EcommerceProviderInterface
{
    public function getStoreDetails()
    {
        return $this->getStoreInfoDetails();
    }

    public function getProductsList()
    {
        return $this->getProducts();
    }
    public function showProductDetails(Request $request)
    {
        return $this->getProductDetails($request);

    }
    public function createCustomer(CreateCustomerRequest $request)
    {
        return $this->createCustomerRequest($request);
    }
    public function createOrder(array $orderData)
    {
        return $this->createOrderRequest($orderData);
    }
}
