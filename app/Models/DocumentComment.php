<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DocumentComment extends Model
{
    use HasFactory;
    protected $table = 'document_comments';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['documentID','userID','content','totalReplies'];

    protected $appends = ['time'];

    public function getTimeAttribute()
    {
        Carbon::setLocale('vi'); 

        $dt = new Carbon($this->created_at);
        $now = Carbon::now();

        return $dt->diffForHumans($now);
    }
    public function documents() {
        return $this->belongsTo(Document::class,'documentID','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }

    public function replies() {
        return $this->hasMany(DocumentCommentReply::class,'commentID','id');
    }
}
