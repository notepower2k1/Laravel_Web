<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookMark extends Model
{
    use HasFactory;

    protected $table = 'book_marks';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['bookID', 'userID'];


    public function books() {
        return $this->belongsTo(Book::class,'bookID','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }

   

}
