<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\RegisterUserRequest;
use App\Services\Auth\UserAuthService;
use Illuminate\Support\Facades\Log;

class UserRegisterApiController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        try {
            return (new UserAuthService())->register($request);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse($exception->getMessage());
        }
    }
}
