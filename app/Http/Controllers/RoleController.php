<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    public function getRoles()
    {
        try {
            $users = User::with('roles')->whereHas('roles', function($q){
                $q->where('name', '<>', '');
            })->get();
            $roles = Role::with(['permissions'])->get();
            return response([
                'users' => $users,
                'roles' => $roles
            ], 200);
        } catch (\Throwable $th) {
            abort(501);
        }
    }

    public function manageRole(Role $role, Request $request)
    {
        $data = null;
        switch ($request->form_type) {
            case 'add':
                $data = Role::create($request);
                break;
            case 'edit':
                $data = $role->update($request);
                break;
            case 'delete':
                $data = $role->delete();
                break;
        }
        return $data;
    }
}
