<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Interfaces\AdminRepositoryInterface;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    private AdminRepositoryInterface $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository) 
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try{
            return response()->json($this->adminRepository->getAllAdmins(), 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreAdminRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAdminRequest $request): JsonResponse
    {
        try{
            $validated = $request->validated();

            return response()->json($this->adminRepository->createAdmin($validated), 201);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try{
            return response()->json($this->adminRepository->getAdminById($id), 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateAdminRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAdminRequest $request, int $id): JsonResponse
    {
        try{
            $validated = $request->validated();

            return response()->json($this->adminRepository->updateAdmin($id, $validated), 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try{
            $this->adminRepository->deleteAdmin($id);

            return response()->json(['success' => __('admin.deleted')], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    public function changePassword(ChangePasswordRequest $request, int $id): JsonResponse
    {
        try{
            $validated = $request->validated();

            $this->adminRepository->changePassword($id, $validated);

            return response()->json(['success' => __('passwords.reset')], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }
}
