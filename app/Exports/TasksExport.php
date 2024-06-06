<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TasksExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
      return Task::select("title", "description","due_date","status","created_by","assigned_to")
        ->where("parent_id",null)->get();
    }
  
  public function headings(): array
  {
    return ["title", "description","due_date","status","created_by","assigned_to"];
  }
}
