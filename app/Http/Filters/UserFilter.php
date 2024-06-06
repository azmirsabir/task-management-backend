<?php
  
  namespace App\Http\Filters;
  
  class UserFilter extends QueryFilter
  {
    
    public function include($value)
    {
      $relations = array_map('trim', explode(',', $value));
      
      return $this->builder->with($relations);
    }
    
    public function id($value)
    {
      return $this->builder->whereIn('id', explode(',', $value));
    }
    
    public function name($value)
    {
      $likeStr = str_replace('*', '%', $value);
      return $this->builder->where('name', 'like', $likeStr);
    }
    
    public function email($value)
    {
      $likeStr = str_replace('*', '%', $value);
      return $this->builder->where('email', 'like', $likeStr);
    }
    
    public function created_at($value)
    {
      $dates = explode(',', $value);
      
      if (count($dates) > 1) {
        return $this->builder->whereBetween('created_at', $dates);
      }
      
      return $this->builder->whereDate('created_at', $value);
    }
  }