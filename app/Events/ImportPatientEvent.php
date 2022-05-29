<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportPatientEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $batch;
    public $broadcastOn = [];

    public $current_auth;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($batch)
    {
        $this->batch = $batch;
        $this->current_auth = auth()->user();

        // dump($this->batch, $this->current_auth->toArray());

        array_push($this->broadcastOn, new Channel('userId'.$this->current_auth->id));

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new Channel('userId'.auth()->user()->id);
        return $this->broadcastOn;
    }
}
