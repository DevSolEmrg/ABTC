<?php

namespace App\Providers;

// use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Queue;
// use Illuminate\Queue\Events\JobProcessed;
// use Illuminate\Queue\Events\JobProcessing;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // if (env('APP_ENV') !== 'local') {
        //     URL::forceScheme('https');
        // }

        // Queue::before(function (JobProcessing $event) {

        //     $payload = json_decode( $event->job->getRawBody() );
        //     $data = unserialize( $payload->data->command );

        //     info('Starting to process job', [
        //             'data_here' => $data,
        //           'connection' => $event->connectionName,
        //           'job' => $event->job,
        //           'payload' => $event->job->payload()
        //     ]);
        // });

        // Queue::after(function (JobProcessed $event) {
        //     info('Finished processing job', [
        //           'connection' => $event->connectionName,
        //           'job' => $event->job,
        //           'payload' => $event->job->payload()
        //     ]);
        // });


    }
}
