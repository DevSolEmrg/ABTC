<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Vaccine;
use App\Http\Requests\VaccinePostRequest;
use Illuminate\Support\Facades\DB;

class VaccineController extends Controller
{
    public function getVaccines()
    {
        return Vaccine::all();
    }

    public function manageVaccines(Vaccine $vaccine, VaccinePostRequest $request)
    {
        DB::beginTransaction();
        $data = null;
        try {
            switch ($request->form_type) {
                case 'add':
                    $vaccine->create($request->validated());
                    break;
                case 'edit':
                    $vaccine->update($request->validated());
                    break;
                case 'delete':
                    $vaccine->delete();
                    break;
            }
            $data = 'Success';
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(response()->json('Failed', 500));
        }
        DB::commit();
        return $data;
    }

}
