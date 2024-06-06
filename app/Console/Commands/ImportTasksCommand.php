<?php

namespace App\Console\Commands;

use App\Events\TaskImportEvent;
use App\Jobs\ImportTasksJob;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Maatwebsite\Excel\Facades\Excel;

class ImportTasksCommand extends Command
{
    protected $signature = 'import:tasks {file}';
    protected $description = 'Import tasks from CSV file';
    public function handle()
    {
      $file = $this->argument('file');
      //check file exist or not
      if (!file_exists($file)) {
        $this->error('File not found: ' . $file);
        return;
      }
      //convert file data into an array
      $data=array_merge(...Excel::toArray((object)[], $file));
      //get header
      $header=$data[0];
      //remove header from the data
      unset($data[0]);
      //divide your array into chunks
      $data_chunks=array_chunk($data,100);
      
      //create the batch job and dispatch it
      $batch=Bus::batch([])->finally(function (Batch $batch) {
        //after all the jobs will finish this call updates the progress with websocket
        event(new TaskImportEvent($batch->id,100));
      })->dispatch();
      
      //adding chunks into the batch
      foreach($data_chunks as $chunk){
        $batch->add(new ImportTasksJob($chunk,$header,$batch->id));
      }
      
      //print info to the console
      $this->info('Data added to the queue.');
      $this->info('BatchId: '.$batch->id);
      
      return 0;
    }
}
