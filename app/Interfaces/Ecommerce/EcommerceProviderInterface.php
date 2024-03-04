<?php

namespace App\Interfaces\Ecommerce;



use App\Http\Requests\Api\Customer\CreateCustomerRequest;
use Illuminate\Http\Request;

interface EcommerceProviderInterface
{
    public function getStoreDetails();

    public function getProductsList();

    public function showProductDetails(Request $request);

    public function createCustomer(CreateCustomerRequest $request);

    public function createOrder(array $orderData);

}
