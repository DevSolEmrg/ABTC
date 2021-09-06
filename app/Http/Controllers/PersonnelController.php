<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Personnel;
use App\Http\Requests\PersonnelPostRequest;
use Illuminate\Support\Facades\DB;

class PersonnelController extends Controller
{
    public function getPersonnels()
    {
        return Personnel::all();
    }

    public function managePersonnel(Personnel $personnel, PersonnelPostRequest $request)
    {
        DB::beginTransaction();
        $data = 'Success';
        try {
            switch ($request->form_type) {
                case 'add':
                    $personnel->create($request->validated());
                    break;
                case 'edit':
                    $personnel->update($request->validated());
                    break;
                case 'delete':
                    $personnel->delete();
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
