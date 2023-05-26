<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class report extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['description','identifier_id','userID','status','type_id','reason_id'];

    
    protected $appends = ['time','notify','identifier','isEnabled'];

    public function getTimeAttribute()
    {
        Carbon::setLocale('vi'); 

        $dt = new Carbon($this->created_at);
        $now = Carbon::now();

        return $dt->diffForHumans($now);
    }
    public function getNotifyAttribute()
    {
        $option = $this->type_id;
        $notify = '';


        switch ($option) {
            case 1:
                $item = Book::findOrFail($this->identifier_id);
                $notify = 'sách '.$item->name;

                break;
            case 2:
                $item = Chapter::findOrFail($this->identifier_id);
                $notify = $item->code.' của sách '.$item->books->name;


                break;
            case 3:
                $item = Document::findOrFail($this->identifier_id);
                $notify = 'tài liệu '.$item->name;

                break;
            case 4:
                $item = ForumPosts::findOrFail($this->identifier_id);
                $notify = 'bài viết có chủ đề '.$item->topic.' của diễn đàn '.$item->forums->name;

               
                break;
            case 5:
                $item = User::findOrFail($this->identifier_id);
                $notify = 'người dùng '.$item->name;


                break;
            case 6:
                $item = Comment::findOrFail($this->identifier_id);
                $book = Book::findOrFail($item->identifier_id);
                $notify = 'bình luận của '.$item->users->name.' về sách '.$book->name;

                break;
            case 7:
                $item = Comment::findOrFail($this->identifier_id);
                $document = Document::findOrFail($item->identifier_id);

                $notify = 'bình luận của '.$item->users->name.' về tài liệu '.$document->name;

                break;
        
            case 8:
                $item = Comment::findOrFail($this->identifier_id);
                $post = ForumPosts::findOrFail($item->identifier_id);

                $notify = 'bình luận của '.$item->users->name.' về bài viết '.$post->topic;

               
                break;
            case 9:
                $item = Reply::findOrFail($this->identifier_id);
                $comment = Comment::findOrFail($item->commentID);
                $notify = 'phản hồi bình luận của '.$item->users->name.' về bình luận của '.$comment->users->name;

                break;

            case 10:
                $item = ratingBook::findOrFail($this->identifier_id);
                $notify = 'Đánh giá của '.$item->users->name.' về sách '.$item->books->name;

                break;
            default:
                $notify = null;
        }
        
        return $notify;

    }

    public function getIdentifierAttribute()
    {
        $option = $this->type_id;
        $item = null;

        switch ($option) {
            case 1:
                $item = Book::findOrFail($this->identifier_id);

                break;
            case 2:
                $item = Chapter::findOrFail($this->identifier_id);


                break;
            case 3:
                $item = Document::findOrFail($this->identifier_id);

                break;
            case 4:
                $item = ForumPosts::findOrFail($this->identifier_id);

               
                break;
            case 5:
                $item = User::findOrFail($this->identifier_id);


                break;
            case 6:
                $temp = Comment::findOrFail($this->identifier_id);
                $item = Book::findOrFail($temp->identifier_id);

                break;
            case 7:
                $temp = Comment::findOrFail($this->identifier_id);
                $item = Document::findOrFail($temp->commentID);


                break;   
            case 8:
                $temp = Comment::findOrFail($this->identifier_id);
                $item = ForumPosts::findOrFail($temp->identifier_id);


                break;
            case 9:
                $temp = Reply::findOrFail($this->identifier_id);
                $item = Comment::findOrFail($temp->commentID);

                break;   
          
            case 10:
                $temp = ratingBook::findOrFail($this->identifier_id);
                $item = Book::findOrFail($temp->bookID);

                break;   
            default:
                $item = null;
        }
        
        return $item;

    }

    public function getIsEnabledAttribute(){

        $report = report::where('identifier_id','=',$this->identifier_id)->where('type_id',$this->type_id)->get();
        $flag = true;
        if($report->count() >= 5){
            $flag = false;
        }
        return $flag;
    }

    
    public function types() {
        return $this->belongsTo(reportType::class,'type_id','id');
    }

    public function reasons() {
        return $this->belongsTo(ReportReason::class,'reason_id','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }
}
