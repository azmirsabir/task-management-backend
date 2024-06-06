<?php

namespace App\Jobs;

use App\Events\TaskImportEvent;
use App\Models\Task;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
class ImportTasksJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $chunk;
    protected $header;
    protected $batch_id;
    public function __construct($chunk,$header,$batch_id)
    {
      $this->chunk = $chunk;
      $this->header = $header;
      $this->batch_id = $batch_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      foreach ($this->chunk as $row) {
        $data=array_combine($this->header,$row);
        Task::create($data);
      }

      $batch = Bus::findBatch($this->batch_id);
      $progress = $batch->progress();
      event(new TaskImportEvent($this->batch_id, $progress));
    }
}
