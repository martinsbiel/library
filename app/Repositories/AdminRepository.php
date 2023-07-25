<?php

namespace App\Repositories;

use App\Interfaces\AdminRepositoryInterface;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements AdminRepositoryInterface
{
    protected $admin;

    // model injection
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function getAllAdmins()
    {
        $admins = $this->admin->get();

        if(count($admins) === 0){
            throw new \Exception('Nenhum administrador encontrado.', 404);
        }

        return $admins;
    }

    public function getAdminById($adminId)
    {
        $admin = $this->admin->find($adminId);

        if(!$admin){
            throw new \Exception('Administrador não encontrado.', 404);
        }

        return $admin;
    }

    public function deleteAdmin($adminId)
    {
        $admin = $this->admin->find($adminId);

        if(!$admin){
            throw new \Exception('Administrador não encontrado.', 404);
        }

        $admin->delete();

        return $admin;
    }

    public function createAdmin(array $adminDetails)
    {
        $data = [
            'name' => $adminDetails['name'],
            'email' => $adminDetails['email'],
            'password' => Hash::make($adminDetails['password'])
        ];

        $admin = $this->admin->create($data);

        return $admin;
    }

    public function updateAdmin($adminId, array $newDetails)
    {
        $admin = $this->admin->find($adminId);

        if(!$admin){
            throw new \Exception('Administrador não encontrado.', 404);
        }

        $admin->update($newDetails);

        return $admin;
    }

    public function changePassword($adminId, array $details)
    {
        $admin = $this->admin->find($adminId);

        if(!$admin){
            throw new \Exception('Administrador não encontrado.', 404);
        }

        if(!Hash::check($details['password'], $admin->password)){
            throw new \Exception('Senha incorreta.', 401);
        }

        $admin->update([
            'password' => Hash::make($details['new_password'])
        ]);

        return $admin;
    }
}