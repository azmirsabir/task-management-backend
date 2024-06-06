<?php
  namespace App\Http\Filters;
  
  use Illuminate\Contracts\Database\Eloquent\Builder;
  use Illuminate\Http\Request;
  use Illuminate\Support\Str;
  
  abstract class QueryFilter
  {
    protected $builder;
    protected $request;
    
    public function __construct(Request $request)
    {
      $this->request = $request;
    }
    
    public function apply(Builder $builder)
    {
      $this->builder = $builder;
      foreach ($this->request->all() as $key => $value) {
        if (method_exists($this, $key)) {
          $this->$key($value);
        }
      }
      return $this->builder;
    }
    
    public function filter($arr)
    {
      foreach ($arr as $key => $value) {
        if (method_exists($this, $key)) {
          $this->$key($value);
        }
      }
      
      return $this->builder;
    }
    
    public function sort($value)
    {
      $sortFields = explode(',', $value);
      foreach ($sortFields as $sortField) {
        $direction = 'asc';
        if (Str::startsWith($sortField, '-')) {
          $direction = 'desc';
          $sortField = substr($sortField, 1);
        }
        
        $this->builder->orderBy($sortField, $direction);
      }
    }
    
  }