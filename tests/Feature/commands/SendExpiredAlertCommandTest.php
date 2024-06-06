<?php

namespace Tests\Feature\commands;

use Tests\TestCase;
use App\Models\Task;
use App\Events\TaskExpiryAlertEvent;
use Illuminate\Support\Facades\Event;

class SendExpiredAlertCommandTest extends TestCase
{
  public function test_send_task_expiry_alert_command()
  {
    Event::fake();
    
    $expiredTask1 = Task::factory()->create(['due_date' => now()->subDays(1)]);
    $expiredTask2 = Task::factory()->create(['due_date' => now()->subDays(2)]);
    
    $this->artisan('app:send-task-expiry-alert')
      ->expectsOutput('Expired tasks alerts sent.')
      ->assertExitCode(0);
    
    Event::assertDispatched(TaskExpiryAlertEvent::class, function ($event) use ($expiredTask1, $expiredTask2) {
      return $event->task->id === $expiredTask1->id || $event->task->id === $expiredTask2->id;
    });
  }
}
