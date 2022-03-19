<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReferencePostRequest;
use App\Models\Reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function getInstances()
    {
        return json_encode((new \App\Constants)->enumValues());
    }

    public function manageInstance(Reference $reference, ReferencePostRequest $request)
    {
        DB::beginTransaction();
        $data = 'Success';
        try {
            switch ($request->form_type) {
                case 'add':
                    $reference->create($request->validated());
                    break;
                case 'edit':
                    $reference->update($request->validated());
                    break;
                case 'delete':
                    $reference->delete();
                    break;
            }
        } catch (\Throwable $th) {
            DB ::rollBack();
            abort(response()->json('Failed', 500));
        }
        DB::commit();
        return $data;
    }

}
