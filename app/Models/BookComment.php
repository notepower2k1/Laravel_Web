<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BookComment extends Model
{
    use HasFactory;
    protected $table = 'book_comments';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['bookID','userID','content','totalReplies'];

    protected $appends = ['time'];

    public function getTimeAttribute()
    {
        Carbon::setLocale('vi'); 

        $dt = new Carbon($this->created_at);
        $now = Carbon::now();

        return $dt->diffForHumans($now);
    }

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
