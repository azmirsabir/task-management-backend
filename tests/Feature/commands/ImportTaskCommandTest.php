<?php

namespace Tests\Feature\commands;

use App\Events\TaskImportEvent;
use Illuminate\Bus\Batch;
use Illuminate\Bus\PendingBatch;
use Illuminate\Support\Facades\Bus;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;


class ImportTaskCommandTest extends TestCase
{
  public function test_import_tasks_command()
  {
    Excel::fake();
    Bus::fake();
    
    $filePath = storage_path('app/tasks.csv');
    
    $this->artisan('import:tasks', ['file' => $filePath])
      ->expectsOutput('Data added to the queue.')
      ->assertExitCode(0);
    
    Excel::assertQueued($filePath, function ($import) {
      return true;
    });
    
    Bus::assertDispatched(PendingBatch::class, function ($pendingBatch) {
      $batch = $pendingBatch->batch();
      return $batch instanceof Batch && $batch->count() > 0;
    });
    
    Event::assertDispatched(TaskImportEvent::class);
  }
}
