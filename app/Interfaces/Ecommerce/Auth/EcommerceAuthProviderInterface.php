<?php

namespace App\Interfaces\Ecommerce\Auth;



use Illuminate\Http\Request;

interface EcommerceAuthProviderInterface
{
    public function sendAuthRequest();

    public function handleCallbackRequest(Request $request);

}
