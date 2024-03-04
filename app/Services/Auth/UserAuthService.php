<?php

namespace App\Services\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Requests\Api\User\LoginUserRequest;
use App\Http\Requests\Api\User\RegisterUserRequest;
use App\Http\Resources\ApiUserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthService
{
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)){
            return ResponseHelper::errorResponse('Invalid credentials',401);
        }
        $user = Auth::user();
        if (!$user->is_admin) {
            return $this->generateAccessTokenResponse($user);
        }
        return ResponseHelper::errorResponse('Unauthorized',401);
    }

    public function register(RegisterUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 0,
        ]);

        return $this->generateAccessTokenResponse($user);
    }

    private function generateAccessTokenResponse($user)
    {
        $accessToken = $user->createToken('User Token', ['user']);
        $expirationTime = Carbon::now()->addDay();
        $accessToken->token->expires_at = $expirationTime;
        $accessToken->token->save();

        return response()->json([
            'accessToken' => $accessToken->accessToken,
            'accessTokenExpirationTime' => $expirationTime,
            'tokenType' => 'Bearer',
            'user'=>ApiUserResource::make($user)
        ]);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return ResponseHelper::successResponse('Successfully logged out');
    }
}
