<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
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
            return response()->json(['error' => $e->getMessage()], $e->getCode());
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
}
