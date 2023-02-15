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
    'description' ,'status','slug','type_id','image','userCreatedID'];


    public function types() {
        return $this->belongsTo(Type::class,'type_id','id');
    }

    public function chapters() {
        return $this->hasMany(Chapter::class);
    }

}
