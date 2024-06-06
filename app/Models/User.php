<?php

namespace App\Models;

use App\Traits\searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles,searchable;
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $searchable=[
      'id',
      'name',
      'email'
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'created_at'=>'datetime:Y-m-d',
            'updated_at'=>'datetime:Y-m-d',
            'password' => 'hashed',
        ];
    }
    public function posts(): HasMany
    {
      return $this->hasMany(Post::class);
    }
    public function tasks()
    {
      return $this->hasMany(Task::class, 'assigned_to');
    }
    public function scopeTesterWithLessTask(){
      return $this->role('tester')->withCount('tasks')->orderBy('tasks_count');
    }
}
