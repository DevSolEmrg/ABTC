<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Vaccine;
use App\Http\Requests\VaccinePostRequest;

class VaccineController extends Controller
{
    public function getVaccines()
    {
        return Vaccine::all();
    }

    public function manageVaccines(Vaccine $vaccine, VaccinePostRequest $request)
    {
        $data = null;
        switch ($request->form_type) {
            case 'add':
                $data = Vaccine::create($request->validated());
                break;
            case 'edit':
                $data = $vaccine->update($request->validated());
                break;
            case 'delete':
                $data = $vaccine->delete();
                break;
        }
        return $data;
    }

}
