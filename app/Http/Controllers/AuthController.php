<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\CheckResetPasswordCodeRequest;
use App\Http\Requests\ProfileImageRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());
        return response()->json(['message' => 'Verification code sent to your email.'], 201);
    }

    public function verifyCodeOnly(VerifyCodeRequest $request): JsonResponse
    {
        $token = $this->authService->verifyCodeOnly($request->validated());

        if (!$token) {
            return response()->json(['message' => 'Invalid verification code.'], 400);
        }

        return response()->json(['message' => 'Email verified successfully.', 'token' => $token], 200);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->validated());

        if (!$token) {
            return response()->json(['message' => 'Invalid credentials or email not verified.'], 401);
        }

        return response()->json(['token' => $token], 200);
    }

    public function userForgetPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $this->authService->forgotPassword($request->validated());
        return response()->json(['message' => 'Password reset code sent.'], 200);
    }

    public function userCheckPasswordCode(CheckResetPasswordCodeRequest $request): JsonResponse
    {
        $isValid = $this->authService->checkResetPasswordCode($request->validated());

        return $isValid
            ? response()->json(['message' => 'Code is valid.'], 200)
            : response()->json(['message' => 'Code is expired or invalid.'], 400);
    }

    public function userResetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $isReset = $this->authService->resetPassword($request->validated());

        return $isReset
            ? response()->json(['message' => 'Password reset successfully.'], 200)
            : response()->json(['message' => 'Invalid or expired code.'], 400);
    }
 

}
