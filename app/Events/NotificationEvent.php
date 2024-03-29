<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    //public function __construct($data)
    public function __construct()
    {
        //$this->data = compact('data');
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['event-notifications'];
    }
}
