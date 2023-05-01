<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyLike extends Model
{
    use HasFactory;
    protected $table = 'reply_likes';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['isLike','replyID','userID'];

    public function replies() {
        return $this->belongsTo(Reply::class,'replyID','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }
}
