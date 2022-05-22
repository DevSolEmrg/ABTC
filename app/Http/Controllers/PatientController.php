<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientHistoryPostRequest;
use Illuminate\Http\Request;
use App\Models\{Patient, PatientHistory, Treatment};
//use Carbon\Carbon;
use App\Http\Requests\PatientPostRequest;
use App\Jobs\ImportPatient;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function getPatients(Request $request)
    {
        $patient = Patient::with(['history' => function($q){
            $q->with(['treatment']);
        }, 'last_history' => function($q){
            $q->with(['treatment']);
        }])->withCount('history')
        ->when(!!$request->search_param, function ($query) use ($request) {
            return $query->where(DB::raw('concat(name," ",address," ",contact_number)'), 'LIKE', '%' . $request->search_param . '%');
        })->orderBy('id', 'DESC')->paginate(10);

        return $this->unsetKey(
            $patient,
            ['links', 'first_page_url', 'last_page_url', 'next_page_url', 'path', 'prev_page_url']
        );
    }

    public function unsetKey($collection, $to_exclude = []) {
        $data = $collection->toArray();
        foreach ($to_exclude as $key) unset($data[$key]);
        return $data;
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

    public function managePatientHistory(PatientHistory $patient_history, PatientHistoryPostRequest $request)
    {
        DB::beginTransaction();
        $data = 'Success';
        try {
            switch ($request->form_type) {
                case 'add':
                    $data = $patient_history->create($request->validated());
                    break;
                case 'edit':
                    $data = $patient_history->update($request->validated());
                    break;
                case 'delete':
                    $data = $patient_history->delete();
                    break;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(response()->json('Failed', 500));
        }
        DB::commit();
        return $data;
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
                    $treatment = Treatment::find($request->id);
                    $treatment->patient_history_id = $request->patient_history_id;
                    $treatment->designated_day = $request->designated_day;
                    $treatment->date = $request->date;
                    $treatment->time = $request->time;
                    $treatment->vaccine_id = $request->vaccine_id;
                    $treatment->save();
                    break;
                case 'delete':
                    //$treatment->delete();
                    $treatment = Treatment::find($request->id);
                    $treatment->delete();
                    break;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(response()->json('Failed', 500));
        }
        DB::commit();
        return $data;
    }

    public function importPatients(Request $request)
    {
        // return ImportPatient::dispatch($request);
        //ImportPatient::dispatch();
        //return 'done';
        // dd(collect($request)->chunk(10));

        $batch = Bus::batch([])->then(function (Batch $batch) {
                // info('Batch then section ran...'.$batch->id);
            })->catch(function (Batch $batch, Throwable $e) {
                // info(print_r($e->getMessage(), true));
            })->finally(function (Batch $batch) {
                // DB::table('job_batches')->where('id', $batch->id)->delete();
            })->name('Import Patient')->dispatch();

        try {
            // return ['status' => 'success', 'batch' => $batch];
            $total_item = count($request->toArray());
            foreach (collect($request)->chunk(30) as $key=>$patients_chunk) {
                foreach ($patients_chunk as $i=>$patient) {
                    if ($key == 0 && $i == 0) {
                        $batch->add(new ImportPatient(
                            $patient,
                            auth()->user(),
                            [
                                'current_item_number' => $i + 1,
                                'total_item' => $total_item
                            ]
                        ));
                        break;
                    }
                }
            }
            return ['status' => 'success', 'batch' => $batch];

        } catch (\Throwable $th) {
            $batch->cancel();
            return ['status' => 'failed', 'batch' => $batch];
        }

    }

}
