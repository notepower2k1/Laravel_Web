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

    protected $fillable = ['topic','content','forumID','userCreatedID','slug','totalComments'];

    protected $appends = ['time','firstImage'];

    public function getTimeAttribute()
    {
        Carbon::setLocale('vi'); 

        $dt = new Carbon($this->created_at);
        $now = Carbon::now();

        return $dt->diffForHumans($now);
    }


    public function getFirstImageAttribute()
    {
        
        $content = $this -> content;

        //https://storage.googleapis.com/...
        $urlRegex = '/(https?:\/\/storage.googleapis.com[^\s]+)/';
    
        preg_match_all($urlRegex, $content, $matches);
        
        $imageUrl = '';
        if (count($matches) > 0) {
            
            if($matches[0]){
                $temp = $matches[0][0];
                $temp = substr($temp, 0, strpos($temp, '"'));
                $imageUrl = $temp;
            }

        } else {
            $imageUrl = '';

        }

        return $imageUrl;
    }

    public function forums() {
        return $this->belongsTo(Forum::class,'forumID','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userCreatedID','id');
    }
}
