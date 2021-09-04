<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Patient};
//use Carbon\Carbon;
use App\Http\Requests\PatientPostRequest;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function getPatients()
    {
        return Patient::with(['history', 'last_history'])->withCount('history')->orderBy('id', 'DESC')->get();
    }

    public function managePatients(Patient $patient, PatientPostRequest $request)
    {
        //$request->birth_date = Carbon::parse($request->birth_date)->timezone('Asia/Manila')->format('Y-m-d');

        // $request->merge([
        //     'birth_date' => Carbon::parse($request->birth_date)->timezone('Asia/Manila')->format('Y-m-d')
        // ]);
        DB::beginTransaction();
        $data = null;
        try {
            switch ($request->form_type) {
                case 'add':
                    $patient->create($request->validated());
                    break;
                case 'edit':
                    $patient->update($request->validated());
                    break;
                case 'delete':
                    $patient->delete();
                    break;
            }
            $data = 'Success';
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(response()->json('Failed', 500));
        }
        DB::commit();
        return $data;
        //dd("patient", $request->validated(), $request->all(), $request->birth_date);
    }

}
