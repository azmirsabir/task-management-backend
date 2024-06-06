<?php

namespace App\Console\Commands;

use App\Events\TaskExpiryAlertEvent;
use App\Models\Task;
use Illuminate\Console\Command;

class SendExpiredAlertCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-task-expiry-alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      $expired_tasks=Task::expiredTasks()->get();
      foreach ($expired_tasks as $task){
        event(new TaskExpiryAlertEvent($task));
      }
      $this->info('Expired tasks alerts sent.');
    }
}
