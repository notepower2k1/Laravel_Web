<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPosts extends Model
{
    use HasFactory;
    protected $table = 'forum_posts';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['topic','content','forumID','userCreatedID','slug','image'];

    public function forum() {
        return $this->belongsTo(Forum::class,'forumID','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userCreatedID','id');
    }
}
