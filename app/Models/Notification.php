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

    //0 - Hide  && 1 - Show
    protected $fillable = ['chapter_id','userID','status'];

    protected $appends = ['time'];

    public function getTimeAttribute()
    {
        Carbon::setLocale('vi'); 

        $dt = new Carbon($this->created_at);
        $now = Carbon::now();

        return $dt->diffForHumans($now);
    }


    public function chapters() {
        return $this->belongsTo(Chapter::class,'chapter_id','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }
}
