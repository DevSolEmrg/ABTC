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
}
