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

class TaskExpiryAlertEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
  
    protected $task;
    
    public function __construct($task)
    {
        $this->task=$task;
    }
    public function broadcastOn(): array
    {
      //broadcast it on a private channel
      return [
        new PrivateChannel('task-expiry-alert.' . $this->task->created_by),
      ];
    }
    public function broadcastWith(): array
    {
      return [
        'task_id'=>$this->task->id,
        'task_title'=>$this->task->title,
        'assigned_to'=>$this->task->assigned_to,
        'due_date'=>$this->task->due_date,
      ];
    }
}
