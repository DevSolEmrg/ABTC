<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\{Role, Permission};
use App\Models\{User};
use Illuminate\Support\Facades\DB;

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
                'roles' => $roles,
                'permissions' => Permission::get()
            ], 200);
        } catch (\Throwable $th) {
            abort(501);
        }
    }

    public function manageRole(Role $role, Request $request)
    {
        DB::beginTransaction();
        $data = 'Success';
        try {
            switch ($request->form_type) {
                case 'add':
                    $role = $role->create(['name' => $request->name, 'description' => $request->description]);
                    foreach ($request->selected_permission as $permit) {
                        $permission = Permission::findByName($permit);
                        if ($permission) {
                            $role->givePermissionTo($permission->name);
                        }
                    }
                    break;
                case 'edit':
                    if (!$role) return abort('No role found', 422);
                    $toRemove = $role->permissions()->whereNotIn('name', $request->selected_permission)->get();
                    if (count($toRemove)) {
                        foreach($toRemove as $value) {
                            $role->revokePermissionTo($value->name);
                        }
                    }
                    foreach ($request->selected_permission as $permit) {
                        $checkIfExist = $role->permissions()->where('name', $permit)->get();
                        if (!count($checkIfExist)) {
                            $role->givePermissionTo($permit);
                        }
                    }
                    $role->update(['name' => $request->name, 'description' => $request->description]);
                    break;
                case 'delete':
                    $users = User::with('roles')->whereHas('roles', function($q) use($request) { $q->where('name', $request->name); })->get();
                    if (count($users)) {
                        foreach($users as $user) {
                            $userFind = User::find($user->id);
                            $userFind->removeRole($request->name);
                        }
                    }
                    foreach($request->permissions as $permit) {
                        $role->revokePermissionTo($permit['name']);
                    }
                    $role->delete();
                    break;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(response()->json('Failed', 500));
        }
        DB::commit();
        return $data;
    }
}
