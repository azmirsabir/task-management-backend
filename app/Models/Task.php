<?php

namespace App\Models;

use App\Traits\searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory,searchable;
    protected $table='tasks';
    protected $fillable = [
      'title',
      'description',
      'assigned_to',
      'developer_id',
      'due_date',
      'created_by',
      'status',
      'parent_id',
    ];
    protected $searchable=[
      'id',
      'title',
      'description',
      'assignedTo.name',
      'productOwner.name'
    ];
    public function assignedTo()
    {
      return $this->belongsTo(User::class,'assigned_to');
    }
    public function productOwner()
    {
      return $this->belongsTo(User::class,'created_by');
    }
    public function logs(){
      return $this->hasMany(TaskLog::class,'task_id');
    }
    public function subTasks(){
      return $this->hasMany(Task::class,'parent_id');
    }
    public function scopeExpiredTasks()
    {
      return $this->where('due_date', '<=', now());
    }
    public function scopeParentTasks()
    {
      return $this->whereNull('parent_id');
    }
}
