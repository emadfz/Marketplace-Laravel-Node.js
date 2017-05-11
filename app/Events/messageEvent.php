<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class messageEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $userid;
    public $msg;
    public $user_email;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user,$msg,$user_email)
    {
        
        $this->userid = $user;
        $this->msg = $msg;
        $this->user_email = $user_email;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {   
        return ['message-'.$this->userid];
    }
}
