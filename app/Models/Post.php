<?php

namespace App\Models;

use App\Http\Filters\QueryFilter;
use App\Traits\Filterable;
use App\Traits\searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpParser\Builder;

class Post extends Model
{
    use HasFactory,Filterable,searchable;
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'content','user_id'];
    public $timestamps = true;
    
    protected $searchable=[
      'title',
      'content',
      'user.name'
    ];
    
    protected $filterable=[
      'title',
      'content'
    ];
    
    public function user(): BelongsTo
    {
      return $this->belongsTo(User::class,'user_id','id');
    }
    
}
