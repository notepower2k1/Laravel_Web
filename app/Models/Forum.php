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

    protected $fillable = ['slug','name','status','description'];

    public function forumPosts() {
        return $this->hasMany(ForumPosts::class);
    }
}
