<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookComment extends Model
{
    use HasFactory;
    protected $table = 'book_comments';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['bookID','userID','content','totalReplies'];

    public function books() {
        return $this->belongsTo(Book::class,'bookID','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }

    public function replies() {
        return $this->hasMany(BookCommentReply::class,'commentID','id');
    }

}
