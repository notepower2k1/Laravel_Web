<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Notify
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $receiverID;
  
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($receiverID)
    {
        $this->receiverID = $receiverID;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {   
        return ['private_notify_'.$this->receiverID];
    }


    public function broadcastAs()
    {   
        return 'send-notify';
    }
}
