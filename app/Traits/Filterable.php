<?php
  namespace App\Traits;
  use Illuminate\Database\Eloquent\Builder;
  use function PHPUnit\Framework\isEmpty;
  
  trait Filterable
  {
    public function scopeFilter(Builder $builder)
    {
      $appliedFilters = request('filter');
      if(!is_null($appliedFilters) || !isEmpty($appliedFilters)){
        $keys = array_intersect($this->filterable, array_keys($appliedFilters));
        
        foreach ($keys as $key) {
          if (array_key_exists($key, $appliedFilters)) {
            $builder->whereIn($key, [$appliedFilters[$key]]);
          }
        }
      }
      
      if(request()->has('from')){
        $builder->where('created_at','>=', request('from'));
      }
      
      if(request()->has('to')){
        $builder->where('created_at','<', request('to'));
      }
      
      return $builder;
    }
  }