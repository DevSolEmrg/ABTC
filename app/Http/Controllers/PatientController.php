<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Patient};
//use Carbon\Carbon;
use App\Http\Requests\PatientPostRequest;

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

        return Patient::create($request->validated());
        //dd("patient", $request->validated(), $request->all(), $request->birth_date);
    }

}
