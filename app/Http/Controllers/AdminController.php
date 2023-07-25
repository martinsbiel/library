<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Interfaces\AdminRepositoryInterface;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminRequest $request)
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminRequest $request, $id)
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $this->adminRepository->deleteAdmin($id);

            return response()->json(['success' => 'Administrador excluído com sucesso.'], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }

    public function changePassword(ChangePasswordRequest $request, $id)
    {
        try{
            $validated = $request->validated();

            $this->adminRepository->changePassword($id, $validated);

            return response()->json(['success' => 'Senha alterada com sucesso.'], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        }
    }
}
