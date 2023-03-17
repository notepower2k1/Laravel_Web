<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ForumPosts extends Model
{
    use HasFactory;
    protected $table = 'forum_posts';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['topic','content','forumID','userCreatedID','slug','image','totalComments'];

    protected $appends = ['time','url'];

    public function getTimeAttribute()
    {
        Carbon::setLocale('vi'); 

        $dt = new Carbon($this->created_at);
        $now = Carbon::now();

        return $dt->diffForHumans($now);
    }

    public function getUrlAttribute()
    {
        $expiresAt = new \DateTime('tomorrow');
        $firebase_storage_path = 'postImage/';       
        $imageReference = app('firebase.storage')->getBucket()->object($firebase_storage_path.$this->image);

        if ($imageReference->exists()) {
            $imageURL = $imageReference->signedUrl($expiresAt);
        } else {
            $imageURL = '';
        }
        return $imageURL;
    }

    public function forums() {
        return $this->belongsTo(Forum::class,'forumID','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userCreatedID','id');
    }
}
