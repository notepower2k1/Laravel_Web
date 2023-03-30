<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentComment extends Model
{
    use HasFactory;
    protected $table = 'document_comments';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['documentID','userID','content','totalReplies'];

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
