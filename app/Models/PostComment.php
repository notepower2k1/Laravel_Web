<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;
    protected $table = 'post_comments';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['content','postID','userID','totalReplies'];

    public function posts() {
        return $this->belongsTo(ForumPosts::class,'postID','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }

    public function replies() {
        return $this->hasMany(PostCommentReply::class,'commentID','id');
    }
}
