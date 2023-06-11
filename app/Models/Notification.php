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
        $type = $this->type_id;
        $identifier = '';


        switch ($type) {
            case 1:
                $item = Comment::findOrFail($this->identifier_id);
                $identifier = $item;
                break;
            
            case 2:
                $item = Reply::findOrFail($this->identifier_id);
                $identifier = $item;
                break;
            case 3:
                $item = ForumPosts::findOrFail($this->identifier_id);
                $identifier = $item;
                break;
            case 4:
            case 6:
            case 8:
            case 10:
                $item = Book::findOrFail($this->identifier_id);
                $identifier = $item;
                break;
            case 5:
            case 7:
            case 9:
            case 11:
                $item = Document::findOrFail($this->identifier_id);
                $identifier = $item;
                break;
          
            default:
                $identifier = '';
            }
      
        return $identifier;

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
