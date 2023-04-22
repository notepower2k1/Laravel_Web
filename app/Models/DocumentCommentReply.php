<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DocumentCommentReply extends Model
{
    use HasFactory;
    protected $table = 'document_comment_replies';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['commentID','userID','content'];

    protected $appends = ['time'];

    public function getTimeAttribute()
    {
        Carbon::setLocale('vi'); 

        $dt = new Carbon($this->created_at);
        $now = Carbon::now();

        return $dt->diffForHumans($now);
    }
    public function comments() {
        return $this->belongsTo(DocumentComment::class,'commentID','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }
}
