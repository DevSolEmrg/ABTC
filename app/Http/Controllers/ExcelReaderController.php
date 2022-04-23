<?php

namespace App\Http\Controllers;

use App\Models\ExcelReader;
use Illuminate\Http\Request;

class ExcelReaderController extends Controller
{
    public function getConfigs()
    {
        return ExcelReader::whereUserId(auth()->user()->id)->first();
    }

    public function manageConfig(Request $request)
    {
        return ExcelReader::whereUserId(auth()->user()->id)->first()->update([
            'reader_start_on_row' => $request->start_row,
            'name_box' => json_encode(array_values(collect($request->all())->only([
                "registration_number",
                "registration_date",
                "name",
                "address",
                "age",
                "gender",
                "date_of_incident",
                "place_of_incident",
                "type_of_animal",
                "type_of_exposure",
                "site_of_infection",
                "category",
                "is_washed",
                "rig_date_given",
                "route",
                "d_one",
                "d_tree",
                "d_seven",
                "d_fourteen",
                "d_twenty_eight",
                "brand_name",
                "outcome",
                "animal_status",
                "remarks"
            ])->toArray())),
        ]);
    }
}
