<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $primaryKey = 'id';
    public  $timestamps = true;

    protected $fillable = ['content','identifier_id','type_id','userID','totalReplies','totalLikes'];

    protected $appends = ['time','identifier'];

    public function getTimeAttribute()
    {
        Carbon::setLocale('vi'); 

        $dt = new Carbon($this->created_at);
        $now = Carbon::now();

        return $dt->diffForHumans($now);
    }

    public function getIdentifierAttribute()
    {
        $option = $this->type_id;
        $identifier = collect();


        switch ($option) {
            case 1:
                $identifier = Document::findOrFail($this->identifier_id);
                break;
            case 2:
                $identifier = Book::findOrFail($this->identifier_id);        
  
                break;
            case 3:
                $identifier = ForumPosts::findOrFail($this->identifier_id);  
        
                break;
            default:
                $identifier = collect();
        }
        
        return $identifier;

    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }

    public function types() {
        return $this->belongsTo(CommentType::class,'type_id','id');
    }

    public function replies() {
        return $this->hasMany(Reply::class,'commentID','id');
    }

    public function likes() {
        return $this->hasMany(CommentLike::class,'commentID','id');
    }
}
