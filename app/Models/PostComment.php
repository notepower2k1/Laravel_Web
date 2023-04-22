<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PostComment extends Model
{
    use HasFactory;
    protected $table = 'post_comments';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['content','postID','userID','totalReplies'];

    protected $appends = ['time'];

    public function getTimeAttribute()
    {
        Carbon::setLocale('vi'); 

        $dt = new Carbon($this->created_at);
        $now = Carbon::now();

        return $dt->diffForHumans($now);
    }
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
