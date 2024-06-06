<?php

namespace App\Imports;

use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterChunk;

class PostsImport implements ToModel,ToCollection, WithBatchInserts,WithChunkReading, ShouldQueue, WithEvents
{
    protected $totalRows;
    protected $processedRows = 0;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
    
    }
  
    public function model(array $row): Model|Post|null
    {
      return new Post([
        'title' => $row[0],
        'content' => $row[1],
        'user_id' => $row[2],
      ]);
    }
  
    public function rules(): array
    {
      return [
//        'title' => 'required|string|max:50',
//        'content' => 'required|string|max:255',
//        'user_id' => 'required|integer',
      ];
    }
    
    public function chunkSize(): int
    {
      return 4;
    }

    public function batchSize(): int
    {
      return 2;
    }
  
    public function registerEvents(): array
    {
      return [
        AfterChunk::class => function (AfterChunk $event) {
        Log::error($this->chunkSize());
//          $this->processedRows += $this->chunkSize();
//          $percentage = min(100, ($this->processedRows / $this->totalRows) * 100);
//          ImportProgress::dispatch($percentage);
        },
      ];
    }
}
