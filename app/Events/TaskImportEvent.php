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

class TaskImportEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
  
    protected $batch_id;
    protected $percent;
    public function __construct($batch_id,$percent)
    {
      $this->batch_id=$batch_id;
      $this->percent=$percent;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
      //broadcast it on a private channel
      return [
        new PrivateChannel('import-task-progress.' . $this->batch_id),
      ];
    }
    
    public function broadcastWith(): array
    {
      return [
        'batch_id'=>$this->batch_id,
        'percent'=>$this->percent,
      ];
    }
}
