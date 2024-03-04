<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LoginUserRequest;
use App\Services\Auth\UserAuthService;
use Illuminate\Support\Facades\Log;

class UserLoginApiController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        try {
            return (new UserAuthService())->login($request);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse($exception->getMessage());
        }
    }
}
