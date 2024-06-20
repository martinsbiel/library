<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendPasswordResetLinkRequest;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository) 
    {
        $this->authRepository = $authRepository;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->validated();

            return response()->json(['token' => $this->authRepository->login($credentials)], 200);
        } catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authRepository->logout($request);

            return response()->json(['success' => __('auth.logout')], 200);
        } catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function sendPasswordResetLink(SendPasswordResetLinkRequest $request): JsonResponse
    {
        try{
            $validated = $request->validated();

            $this->authRepository->sendPasswordResetLink($validated);

            return response()->json(['success' => __('passwords.sent')], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try{
            $validated = $request->validated();

            $this->authRepository->resetPassword($validated);

            return response()->json(['success' => __('passwords.reset')], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }
}
