<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientHistoryPostRequest;
use Illuminate\Http\Request;
use App\Models\{Patient, PatientHistory, ProcessedJob, Treatment};
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
            $item_per_chunk = 30;
            $counter = 0;
            foreach (collect($request)->chunk($item_per_chunk) as $key=>$patients_chunk) {
                // dd($key * $item_per_chunk, collect($request)->chunk($item_per_chunk));
                $counter = ((($key - 1) < 0 ? 0 : $key - 1) * $item_per_chunk);

                foreach ($patients_chunk as $i=>$patient) {
                    // if ($key == 0 && $i <= 1) {
                        $batch->add(new ImportPatient(
                            $patient,
                            auth()->user(),
                            [
                                'current_item_number' => $counter + ($i + 1),
                                'total_item' => $total_item
                            ]
                        ));

                        ProcessedJob::create([
                            'user_id' => auth()->user()->id,
                            'temp_id' => $patient['patient']['temp_id'],
                            'batch_id' => $batch->id,
                            'payload' => json_encode($patient),
                            'status' => '',
                            'remarks' => '',
                        ]);

                    // } else {
                    //     break;
                    // }
                }
            }
            return ['status' => 'success', 'batch_id' => $batch->id];

        } catch (\Throwable $th) {
            $batch->cancel();
            return abort(response()->json(['status' => 'failed', 'batch_id' => $batch->id], 500));
        }

    }

    public function ProcessedJob()
    {
        $by_batch = array();
        //  ProcessedJob::select('batch_id')->distinct()->get()->pluck('batch_id')->toArray();

        foreach (ProcessedJob::select('batch_id')->distinct()->get()->pluck('batch_id')->toArray() as $batch_id) {
            $b = DB::table('job_batches')->whereId($batch_id)->first();
            $b->dispatch_on = date('y/m/Y H:i', $b->created_at);
            $b->jobs = ProcessedJob::whereBatchId($batch_id)->whereUserId(auth()->user()->id)->get()->toArray();
            array_push($by_batch, $b);
        }

        return $by_batch;

        // $processed_job = ProcessedJob::query();

        // if (request()->has('user_id')) {
        //     $processed_job->whereUserId(auth()->user()->id);
        // }

        // return $processed_job->get();
    }

    public function deleteProcessedJob($batch_id)
    {
        DB::beginTransaction();
        $response = 'success';
        try {
            ProcessedJob::whereBatchId($batch_id)->whereUserId(auth()->user()->id)->delete();
            DB::table('job_batches')->whereId($batch_id)->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(response()->json('Failed', 500));
        }
        return $response;
    }

    public function dashboardData()
    {
        // if (request()->has('from') && request()->has('to')) {
        //     ->whereBetween('created_at', [$selected[0].' 00:00:00', $selected[1].' 23:59:59'])
        // }

        // $date_range = [request('from'), request('to')];

        return response()->json([
            'count_severe' => Patient::with(['history' => function ($q){
                    return $q->whereBetween('created_at', [request('from')." 00:00:00", request('to')." 23:59:59"])->severeExposure();
                }])
                ->whereHas('history', function ($q){
                    return $q->whereBetween('created_at', [request('from')." 00:00:00", request('to')." 23:59:59"])->severeExposure();
                })->get(),
            'count_minor' => Patient::with(['history' => function ($q){
                    return $q->whereBetween('created_at', [request('from')." 00:00:00", request('to')." 23:59:59"])->minorExposure();
                }])
                ->whereHas('history', function ($q){
                    return $q->whereBetween('created_at', [request('from')." 00:00:00", request('to')." 23:59:59"])->minorExposure();
                })->get(),
            'count_no_exposure' => Patient::with(['history' => function ($q){
                    return $q->whereBetween('created_at', [request('from')." 00:00:00", request('to')." 23:59:59"])->noExposure();
                }])
                ->whereHas('history', function ($q){
                    return $q->whereBetween('created_at', [request('from')." 00:00:00", request('to')." 23:59:59"])->noExposure();
                })->get(),
        ]);
    }

}
