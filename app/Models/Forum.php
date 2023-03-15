<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;
    protected $table = 'forums';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['slug','name','status','description','numberOfPosts'];

    public function forumPosts() {
        return $this->hasMany(ForumPosts::class,'forumID','id');
    }
}
