<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Patient};

class PatientController extends Controller
{
    public function getPatients()
    {
        return Patient::get();
    }

    public function managePatients(Patient $patient, Request $request)
    {
        dd("patient", $request);
    }

}
