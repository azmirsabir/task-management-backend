<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskAssigned extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $task;
    public function __construct(Task $task)
    {
        $this->task = $task;
    }
    
    public function build()
    {
      return $this->subject('Task Assigned')
        ->view('view.sendMailAssigned')
        ->with(['task' => $this->task]);
    }
}
