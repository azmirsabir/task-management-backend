<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class postImporterJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  
  public $chunk;
  public $header;
  
  /**
   * Create a new job instance.
   */
  public function __construct(array $chunk, array $header)
  {
    $this->chunk = $chunk;
    $this->header = $header;
    
    // Log the initial state of variables
    Log::info('Constructor - Chunk:', $chunk);
    Log::info('Constructor - Header:', $header);
  }
  
  /**
   * Execute the job.
   */
  public function handle(): void
  {
//    foreach ($this->chunk as $key => $value) {
//      Log::info("Processing row {$key}: {$value}");
//    }
  }
}
