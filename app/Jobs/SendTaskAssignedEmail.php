<?php

namespace App\Jobs;

use App\Mail\TaskAssigned;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTaskAssignedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $task;
    
    public function __construct(Task $task)
    {
      $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      $assignedUser = $this->task->assignedTo;
      Mail::to($assignedUser->email)->send(new TaskAssigned($this->task));
    }
}
