<?php

namespace Tests\Feature\commands;

use App\Models\Task;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

class ExportTaskCommandTest extends TestCase
{
  protected function setUp(): void
  {
    parent::setUp();
    Event::fake();
  }
  
  public function test_export_tasks_command_creates_csv_file()
  {
    Task::factory(5)->create();
    Storage::fake();
    
    $filePath = storage_path('app/tasks.csv');
    
    $this->artisan('import:tasks', ['file' => $filePath])
      ->expectsOutput('Data added to the queue.')
      ->assertExitCode(0);
    
    Storage::assertExists($filePath);
  }
}
