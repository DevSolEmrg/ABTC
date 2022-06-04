<?php

namespace App\Jobs;

use App\Events\{ImportPatientEvent};
use App\Http\Requests\{PatientHistoryPostRequest, PatientPostRequest};
use App\Models\{Patient, PatientHistory, ProcessedJob, Treatment};
use Illuminate\Bus\{Batchable, Queueable};
use Illuminate\Contracts\Queue\{ShouldBeUnique, ShouldQueue};
use Illuminate\Foundation\Bus\{Dispatchable};
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Support\Facades\{Auth, DB, Validator};

class ImportPatient implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**The 'pcntl' PHP extension must be installed in order to specify job timeouts.**/
    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    public $failOnTimeout = true;

    protected $patient;
    protected $user;
    protected $item_number;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($patient, $user, $item_number)
    {
        $this->patient = $patient;
        $this->user = $user;
        $this->item_number = $item_number;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!auth()->user()) { Auth::login($this->user, $remember = true); }

        $processed_job = ProcessedJob::whereUserId(auth()->user()->id)
            ->whereTempId($this->patient['patient']['temp_id'])
            ->first();

        if ($this->batch()->cancelled()) {
            // ProcessedJob::create([
            //     'batch_id' => $this->batch()->id,
            //     'payload' => json_encode($this->patient),
            //     'status' => 'Batch Cancelled',
            //     'remarks' => 'Cancelled',
            // ]);
            if (!!$processed_job) {
                $processed_job->update([
                    'status' => 'Batch Cancelled',
                    'remarks' => 'Cancelled',
                ]);
            }
            return $this->fail('cancelled');
        }

        $patient_form_request = new PatientPostRequest;
        $patient_history_form_request = new PatientHistoryPostRequest;

        $patient = $this->patient['patient'];
        $patient_history = $this->patient['patient_history'];
        $patient_treament = $this->patient['patient_treament'];

        DB::beginTransaction();
        try {
            $validated_patient = Validator::make($patient, $patient_form_request->rules(), $patient_form_request->messages())->validate();
            $saved_patient = Patient::create($validated_patient);

            $patient_history['patient_id'] = $saved_patient->id;
            $validated_patient_history = Validator::make($patient_history, $patient_history_form_request->rules(), $patient_history_form_request->messages())->validate();
            $saved_patient_history = PatientHistory::create($validated_patient_history);

            foreach ($patient_treament as $treatment_row) {
                $treatment = new Treatment;
                $treatment->patient_history_id = $saved_patient_history->id;
                $treatment->designated_day = $treatment_row['designated_day'];
                $treatment->date = $treatment_row['date'];
                $treatment->time = $treatment_row['time'];
                $treatment->vaccine_id = $treatment_row['vaccine_id'];
                $treatment->save();
            }

            DB::commit();

            event(new ImportPatientEvent($this->batchInfo()));

            //on dispatch this save/insert list of job and update on success or failed

            // ProcessedJob::create([
            //     'batch_id' => $this->batch()->id,
            //     'payload' => json_encode($this->patient),
            //     'status' => 'Processed',
            //     'remarks' => 'Done',
            // ]);
            if (!!$processed_job) {
                $processed_job->update([
                    'status' => 'Processed',
                    'remarks' => 'Done',
                ]);
            }

            return 'success';
        } catch (\Throwable $th) {
            DB::rollback();

            event(new ImportPatientEvent($this->batchInfo('failed')));

            // ProcessedJob::create([
            //     'batch_id' => $this->batch()->id,
            //     'payload' => json_encode($this->patient),
            //     'status' => 'Failed',
            //     'remarks' => 'Error',
            // ]);
            if (!!$processed_job) {
                $processed_job->update([
                    'status' => 'Failed',
                    'remarks' => 'Error',
                ]);
            }

            return $this->fail($th->getMessage());
        }
    }

    public function failed($exception)
    {
        $this->fail($exception);
    }

    private function batchInfo($job_action = 'success')
    {
        $current_item_number = $this->item_number['current_item_number'];
        $total_item = $this->item_number['total_item'];

        $total_jobs = $this->batch()->totalJobs;
        $pending_jobs = $this->batch()->pendingJobs - 1;
        $progress = round(((intval($current_item_number) / $total_jobs) * 100));
        return [
            'id' => $this->batch()->id,
            'name' => $this->batch()->name,
            'total_jobs' => $total_jobs,
            'pending_jobs' => max($pending_jobs, 0),
            'failed_jobs' => max(($job_action == 'failed' ? $this->batch()->failedJobs : $this->batch()->failedJobs - 1), 0),
            'proccessed_jobs' => $this->batch()->processedJobs() + 1,
            'progress' => max($progress, 0),
            'finished' => $current_item_number == $total_item,
            'cancelled' => $this->batch()->cancelled(),
            'proccessed_data' => $this->patient,
            'current_item_number' => $current_item_number,
        ];

        // return [
        //     'id' => $this->batch()->id,
        //     'name' => $this->batch()->name,
        //     'total_jobs' => $this->batch()->totalJobs,
        //     'pending_jobs' => $this->batch()->pendingJobs,
        //     'failed_jobs' => $this->batch()->failedJobs,
        //     'proccessed_jobs' => $this->batch()->processedJobs(),
        //     'progress' => $this->batch()->progress(),
        //     'finished' => $this->batch()->finished(),
        //     'cancelled' => $this->batch()->cancelled()
        // ];
    }

}
