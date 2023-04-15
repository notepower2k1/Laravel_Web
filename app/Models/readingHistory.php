<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class readingHistory extends Model
{
    use HasFactory;
    protected $table = 'reading_histories';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['bookID','total','userID'];


    public function books() {
        return $this->belongsTo(Book::class,'bookID','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }
}
