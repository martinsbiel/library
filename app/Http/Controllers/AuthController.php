<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendPasswordResetLinkRequest;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository) 
    {
        $this->authRepository = $authRepository;
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();

            return response()->json(['token' => $this->authRepository->login($credentials)], 200);
        } catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authRepository->logout($request);

            return response()->json(['success' => 'Logout realizado com sucesso'], 200);
        } catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function sendPasswordResetLink(SendPasswordResetLinkRequest $request)
    {
        try{
            $validated = $request->validated();

            $this->authRepository->sendPasswordResetLink($validated);

            return response()->json(['success' => 'Link para recuperar senha enviado.'], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try{
            $validated = $request->validated();

            $this->authRepository->resetPassword($validated);

            return response()->json(['success' => 'Senha alterada com sucesso.'], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }
}
