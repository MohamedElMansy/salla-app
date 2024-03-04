<?php

namespace App\Services\Auth;


use App\Http\Requests\Api\Admin\LoginAdminRequest;
use App\Http\Resources\ApiUserResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminAuthService
{
    public function login(LoginAdminRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->is_admin) {
                $accessToken = $user->createToken('Admin Token',['admin']);
                $expirationTime = Carbon::now()->addDay();
                $accessToken->token->expires_at = $expirationTime;
                $accessToken->token->save();

                return response()->json([
                    'accessToken' => $accessToken->accessToken,
                    'accessTokenExpirationTime' => $expirationTime,
                    'tokenType' => 'Bearer',
                    'admin'=>ApiUserResource::make($user)
                ]);
            }
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

}
