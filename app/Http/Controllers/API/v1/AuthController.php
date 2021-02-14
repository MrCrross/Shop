<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $token = auth()->attempt($credentials);

        Log::info('Attempt to login', [
            'email'     => $credentials['email'],
            'autorized' => (bool)$token
        ]);

        if(!$token)
        {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        return $this->responseToken($token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $currentUser = auth()->user();

        Log::info('Show current user', [
            'user' => $currentUser->id
        ]);

        return response()->json($currentUser);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $currentUser = auth()->user();

        Log::info('Refresh token', [
            'user' => $currentUser->id
        ]);

        return $this->responseToken(auth()->refresh());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $currentUser = auth()->user();
        auth()->logout();

        Log::info('Logout', [
            'user' => $currentUser->id
        ]);

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
