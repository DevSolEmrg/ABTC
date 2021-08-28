<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Personnel;
use App\Http\Requests\PersonnelPostRequest;

class PersonnelController extends Controller
{
    public function getPersonnels()
    {
        return Personnel::all();
    }

    public function managePersonnel(Personnel $personnel, PersonnelPostRequest $request)
    {
        $data = null;
        switch ($request->form_type) {
            case 'add':
                $data = Personnel::create($request->validated());
                break;
            case 'edit':
                $data = $personnel->update($request->validated());
                break;
            case 'delete':
                $data = $personnel->delete();
                break;
        }
        return $data;
    }
}
