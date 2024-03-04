<?php

namespace App\Services\Store;


use App\Constants\SystemConstants;
use App\Services\Ecommerce\Services\EcommerceService;

class StoreService
{
    public function getStoreDetails()
    {
        $ecommerceProvider =  (new EcommerceService())->getEcommerceProvider(SystemConstants::DEFAULT_GOVERNMENT_PROVIDER);
        return $ecommerceProvider->getStoreDetails();
    }
}
