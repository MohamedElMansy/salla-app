<?php

namespace App\Services\Product;


use App\Constants\SystemConstants;
use App\Services\Ecommerce\Services\EcommerceService;
use Illuminate\Http\Request;

class ProductService
{
    public $ecommerceProvider;
    public function __construct()
    {
        // get provider
        $this->ecommerceProvider =  (new EcommerceService())->getEcommerceProvider(SystemConstants::DEFAULT_GOVERNMENT_PROVIDER);
    }
    public function getProductsList()
    {
        return $this->ecommerceProvider->getProductsList();
    }
    public function showProductDetails(Request $request)
    {
        return $this->ecommerceProvider->showProductDetails($request);
    }
}
