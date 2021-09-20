<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with('data', [
            'auth' => auth()->user()->with(['roles' => function($q){ $q->with('permissions'); }])->whereId(auth()->user()->id)->first(),
            'enums' => json_encode((new \App\Constants)->enumValues())
        ]);
    }

    public function checkAuth()
    {
        return auth()->user();
    }
}
