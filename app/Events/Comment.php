<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Comment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $id;
    public $eventType; //add-comment | edit-comment | delete-comment | add-reply | edit-reply | delete-reply
    public $typeID;
    public $itemID;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->eventType = $data['eventType'];
        $this->id = strval($data['id']);
        $this->typeID = strval($data['typeID']);
        $this->itemID = strval($data['itemID']);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
  

    public function broadcastOn()
    {   
        return ['comment_'.$this->typeID."_".$this->itemID];
    }


    public function broadcastAs()
    {   
        return 'send-comment';
    }
}
