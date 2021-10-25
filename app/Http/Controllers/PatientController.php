<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Patient, Treatment};
//use Carbon\Carbon;
use App\Http\Requests\PatientPostRequest;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function getPatients()
    {
        return Patient::with(['history' => function($q){
            $q->with(['treatment']);
        }, 'last_history' => function($q){
            $q->with(['treatment']);
        }])->withCount('history')->orderBy('id', 'DESC')->get();
    }

    public function getSelectedPatient(Request $request)
    {
        return Patient::with(['history' => function($q){
            $q->with(['treatment']);
        }, 'last_history' => function($q){
            $q->with(['treatment']);
        }])->withCount('history')->find($request->id);
    }

    public function managePatients(Patient $patient, PatientPostRequest $request)
    {
        //$request->birth_date = Carbon::parse($request->birth_date)->timezone('Asia/Manila')->format('Y-m-d');

        // $request->merge([
        //     'birth_date' => Carbon::parse($request->birth_date)->timezone('Asia/Manila')->format('Y-m-d')
        // ]);
        DB::beginTransaction();
        $data = 'Success';
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
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(response()->json('Failed', 500));
        }
        DB::commit();
        return $data;
        //dd("patient", $request->validated(), $request->all(), $request->birth_date);
    }

    public function manageTreatment(Treatment $treatment, Request $request)
    {
        DB::beginTransaction();
        $data = 'Success';
        try {
            switch ($request->form_type) {
                case 'add':
                    $treatment = new Treatment();
                    $treatment->patient_history_id = $request->patient_history_id;
                    $treatment->designated_day = $request->designated_day;
                    $treatment->date = $request->date;
                    $treatment->time = $request->time;
                    $treatment->vaccine_id = $request->vaccine_id;
                    $treatment->save();
                    break;
                case 'edit':
                    //$treatment->update($request->validated());
                    break;
                case 'delete':
                    //$treatment->delete();
                    break;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(response()->json('Failed'.$th, 500));
        }
        DB::commit();
        return $data;
    }

}
