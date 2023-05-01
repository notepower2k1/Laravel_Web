<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class report extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['description','identifier_id','userID','status','type_id'];

    
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
        $identifier = '';


        switch ($option) {
            case 1:
                $item = Book::findOrFail($this->identifier_id);
                $identifier = 'sách '.$item->name;

                break;
            case 2:
                $item = Chapter::findOrFail($this->identifier_id);
                $identifier = $item->code.' của sách '.$item->books->name;


                break;
            case 3:
                $item = Document::findOrFail($this->identifier_id);
                $identifier = 'tài liệu '.$item->name;

                break;
            case 4:
                $item = ForumPosts::findOrFail($this->identifier_id);
                $identifier = 'bài viết có chủ đề '.$item->topic.' của diễn đàn '.$item->forums->name;

               
                break;
            case 5:
                $item = User::findOrFail($this->identifier_id);
                $identifier = 'người dùng '.$item->name;


                break;
            case 6:
                $item = Comment::findOrFail($this->identifier_id);
                $book = Book::findOrFail($item->identifier_id);
                $identifier = 'bình luận của '.$item->users->name.' về sách '.$book->name;

                break;
            case 7:
                $item = Reply::findOrFail($this->identifier_id);
                $comment = Comment::findOrFail($item->commentID);
                $identifier = 'phản hồi bình luận của '.$item->users->name.' về bình luận của '.$comment->users->name;


                break;   
            case 8:
                $item = Comment::findOrFail($this->identifier_id);
                $document = Document::findOrFail($item->identifier_id);

                $identifier = 'bình luận của '.$item->users->name.' về tài liệu '.$document->name;

                break;
            case 9:
                $item = Reply::findOrFail($this->identifier_id);
                $comment = Comment::findOrFail($item->commentID);
                $identifier = 'phản hồi bình luận của '.$item->users->name.' về bình luận của '.$comment->users->name;

                break;   
            case 10:
                $item = Comment::findOrFail($this->identifier_id);
                $post = ForumPosts::findOrFail($item->identifier_id);

                $identifier = 'bình luận của '.$item->users->name.' về bài viết '.$post->topic;

               
                break;
            case 11:
                $item = Reply::findOrFail($this->identifier_id);
                $comment = Comment::findOrFail($item->commentID);
                $identifier = 'phản hồi bình luận của '.$item->users->name.' về bình luận của '.$comment->users->name;

                break;
            default:
                $item = null;
        }
        
        return $identifier;

    }


    public function types() {
        return $this->belongsTo(reportType::class,'type_id','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }
}
