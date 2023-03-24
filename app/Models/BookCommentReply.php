<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCommentReply extends Model
{
    use HasFactory;
    protected $table = 'book_comment_replies';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['commentID','userID','content'];

    public function comments() {
        return $this->belongsTo(BookComment::class,'commentID','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }
}
