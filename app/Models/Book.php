<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Book extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['name', 'author', 
    'description' ,'isCompleted','slug','type_id','image','userCreatedID','isPublic','language','numberOfChapter'];


    public function types() {
        return $this->belongsTo(BookType::class,'type_id','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userCreatedID','id');
    }

    public function chapters() {
        return $this->hasMany(Chapter::class);
    }

}
