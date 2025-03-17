<?php

namespace App\Http\Controllers\General;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Modules\User\Application\Manager\AuthManager;
use App\Modules\User\Domain\DTO\UserDTO;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        private AuthManager $authManager
    ) {}

    /**
     * Create a user via given credentials and returns a token.
     *
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws Exception
     */
    public function register(CreateUserRequest $request): JsonResponse
    {
        try {
            $userDto = UserDTO::fromCreateRequest($request);
            $user = $this->authManager->register($userDto);
            $token = $user->createToken("auth_token")->plainTextToken;

            return response()->json([
                "message" => "User created successfully.",
                "result" => [
                    "user" => $user,
                    "token" => $token
                ]
            ], 201);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Get a token via given credentials.
     *
     * @param UserLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws Exception
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        try {
            $user = $this->authManager->getByEmail($request->email);

            if (!Hash::check($request->password, $user->password)) {

                throw new Exception("Bad credentials.", 400);
            }

            $token = $user->createToken("auth_token")->plainTextToken;

            return response()->json([
                "message" => "User logined successfully.",
                "result" => [
                    "user" => $user,
                    "token" => $token
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(["message" => "Successfully logged out"], 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json([
            "message" => "User got successfully",
            "result" => ["user" => auth()->user()]
        ], 200);
    }
}
