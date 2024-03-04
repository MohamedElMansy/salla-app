<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\LoginAdminRequest;
use App\Http\Resources\ApiUserResource;
use App\Services\Auth\AdminAuthService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminLoginApiController extends Controller
{
    public function login(LoginAdminRequest $request)
    {
        try {
            return (new AdminAuthService())->login($request);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse($exception->getMessage());
        }
    }
}
