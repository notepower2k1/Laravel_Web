<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Support\Facades\Storage;

class Book extends Model implements Searchable
{
    use HasFactory;
    protected $table = 'books';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['name', 'author', 
    'description' ,'isCompleted','slug','type_id','image','userCreatedID','isPublic','language','numberOfChapter','ratingScore','totalReading','totalBookMarking','totalComments','status'];


    public function types() {
        return $this->belongsTo(BookType::class,'type_id','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userCreatedID','id');
    }

    public function chapters() {
        return $this->hasMany(Chapter::class,'book_id','id');
    }

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        $expiresAt = new \DateTime('tomorrow');
        $firebase_storage_path = 'bookImage/';       
        $imageReference = app('firebase.storage')->getBucket()->object($firebase_storage_path.$this->image);

        if ($imageReference->exists()) {
            $imageURL = $imageReference->signedUrl($expiresAt);
        } else {
            $imageURL = '';
        }
        return $imageURL;
    }

    public function getSearchResult(): SearchResult
    {   
        $url = 'sach/'.$this->id.'/'.$this->slug;

       
        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }

}
