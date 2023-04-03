<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['identifier_id','type_id', 'senderID','receiverID','status'];

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
        $item = collect();
        $option = $this->type_id;

        switch ($option) {
            case 1:
                $item = Book::findOrFail($this->identifier_id);          
                break;
            case 2:
                $item = Document::findOrFail($this->identifier_id);          
                break;
            case 3:
                $item = ForumPosts::findOrFail($this->identifier_id);          
                break;
            case 4:
                $item = BookComment::findOrFail($this->identifier_id);          
                break;
            case 5:
                $item = DocumentComment::findOrFail($this->identifier_id);          
                break;
            case 6:
                $item = PostComment::findOrFail($this->identifier_id);          
                break;
            default:
                $item = collect();
        }
        
        return $item;

    }

    public function types() {
        return $this->belongsTo(NotificationType::class,'type_id','id');
    }

    public function senders() {
        return $this->belongsTo(User::class,'senderID','id');
    }

    public function receivers() {
        return $this->belongsTo(User::class,'receiverID','id');
    }

    
}
