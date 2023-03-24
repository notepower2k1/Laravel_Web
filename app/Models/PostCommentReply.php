<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCommentReply extends Model
{
    use HasFactory;
    protected $table = 'post_comment_replies';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['content','commentID','userID'];

    public function comments() {
        return $this->belongsTo(PostComment::class,'commentID','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }
}
