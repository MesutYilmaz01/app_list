<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(CreateUserRequest $request)
    {
        $user = User::create(
            [
                'username' => $request->username,
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]
        );

        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            'status' => '1',
            'message' => 'User created successfully.',
            'token' => $token
        ]);
    }

    /**
     * Get a token via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserLoginRequest $request)
    {   
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([
                'status' => '0',
                'message' => 'Bad credentials.',
            ]);
        }

        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            'status' => '1',
            'message' => 'User logined successfully.',
            'token' => $token
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
}
