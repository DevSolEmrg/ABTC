<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{User};
use App\Http\Requests\UserPostRequest;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUsers()
    {
        return User::with(['roles' => function($q){ $q->with('permissions'); }])->get();
    }

    public function manageUser(User $user, UserPostRequest $request)
    {
        DB::beginTransaction();
        $data = 'Success';
        try {
            switch ($request->form_type) {
                case 'add':
                    $created_user = $user->create($request->validated());
                    $created_user->assignRole($request->role);
                    break;
                case 'edit':
                    $user->update($request->validated());
                    $user->syncRoles($request->role);
                    break;
                case 'delete':
                    $roles = array_map(function ($role) { return $role->name; }, $user->roles->all());
                    foreach ($roles as $role) $user->removeRole($role);
                    $user->delete();
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
