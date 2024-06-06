<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    use HasFactory;
    protected $table='logs';
    
    protected $fillable=['task_id','assigned_to','action',"details"];
  
    public function user()
    {
      return $this->belongsTo(User::class, 'assigned_to');
    }
    
    public function scopeTaskDeveloper($query, $task_id)
    {
      return $query->where('task_id', $task_id)
        ->whereHas('user.roles', function($query) {
          $query->where('name', 'developer');
        });
    }
    
}
