<?php

namespace App\Console\Commands;

use App\Exports\TasksExport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportTasksCommand extends Command
{
    protected $signature = 'export:tasks {filename=tasks.csv}';
    protected $description = 'Export all tasks';
    public function handle()
    {
      $filename = $this->argument('filename');
      Excel::store(new TasksExport(), $filename);
      
      $this->info("{$filename} exported successfully!");
      
      return 0;
    }
}
