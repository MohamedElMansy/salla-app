<?php

namespace App\Services\Customer;


use App\Constants\SystemConstants;
use App\Http\Requests\Api\Customer\CreateCustomerRequest;
use App\Services\Ecommerce\Services\EcommerceService;

class CustomerService
{
    public function createCustomer(CreateCustomerRequest $request)
    {
        $ecommerceProvider =  (new EcommerceService())->getEcommerceProvider(SystemConstants::DEFAULT_GOVERNMENT_PROVIDER);
        return $ecommerceProvider->createCustomer($request);
    }
}
