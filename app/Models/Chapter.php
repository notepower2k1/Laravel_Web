<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Chapter extends Model
{
    use HasFactory;
    protected $table = 'chapters';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['code','name', 'content','slug','book_id','numberOfWords'];

    protected $appends = ['time'];

    public function getTimeAttribute()
    {
        Carbon::setLocale('vi'); 

        $dt = new Carbon($this->created_at);
        $now = Carbon::now();

        return $dt->diffForHumans($now);
    }


    public function books() {
        return $this->belongsTo(Book::class,'book_id','id');
    }
    
}
