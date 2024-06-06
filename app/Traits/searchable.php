<?php

  namespace App\Traits;
  use Exception;
  use Illuminate\Support\Facades\Log;
  use Illuminate\Support\Str;
  use Illuminate\Contracts\Database\Eloquent\Builder;
  trait searchable{
    public function scopeSearch(Builder $query,$request): Builder
    {
      if(!$this->searchable) throw new Exception("Please define the searchable property in model");
      
      $filters=$request->query('filter', []);
      if($filters){
        $filters=json_decode($filters, true);
        foreach ($filters as $key => $values) {
          if (collect($this->searchable)->contains($key)) {
            
            
            if (!str_contains($key, ".")) {
              // Direct attribute filtering
              $query->whereIn($key,  $values);
            } else {
              
              // Handling relationships
              $relation = Str::beforeLast($key, '.');
              $column = Str::afterLast($key, '.');
              
              foreach ($values as $item) {
                $query->WhereRelation($relation, $column, '=', $item);
              }
              
            }
          } else {
            Log::info($key . " is not searchable");
          }
        }
      }
      
      return $query;
    }
  }