<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookType extends Model
{
    use HasFactory;
    protected $table = 'book_types';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;


    //return $this->hasMany(Comment::class, 'foreign_key', 'local_key');
    //return $this->belongsTo(User::class, 'foreign_key', 'owner_key');

    protected $fillable = ['name','slug'];


    protected $appends = ['total'];

    public function getTotalAttribute()
    {
        $book = Book::where('type_id','=',$this->id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();

        return $book->count();
    }
    public function books() {
        return $this->hasMany(Book::class,'type_id','id');
    }
}
