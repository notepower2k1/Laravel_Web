<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Document extends Model implements Searchable
{
    use HasFactory;
    protected $table = 'documents';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;   

    protected $fillable = ['name', 
    'description' ,'slug','type_id','image','userCreatedID','isPublic','isCompleted','language','file','author','extension','totalDownloading'];


    public function types() {
        return $this->belongsTo(DocumentType::class,'type_id','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userCreatedID','id');
    }


    protected $appends = ['url','documentUrl'];

    public function getUrlAttribute()
    {
        $expiresAt = new \DateTime('tomorrow');
        $firebase_storage_path = 'documentImage/';       
        $imageReference = app('firebase.storage')->getBucket()->object($firebase_storage_path.$this->image);

        if ($imageReference->exists()) {
            $imageURL = $imageReference->signedUrl($expiresAt);
        } else {
            $imageURL = '';
        }
        return $imageURL;
    }


    public function getDocumentUrlAttribute()
    {
        $expiresAt = new \DateTime('tomorrow');
        $firebase_storage_path = 'documentFile/';     
        
        $imageReference = app('firebase.storage')->getBucket()->object($firebase_storage_path.$this -> file);

        if ($imageReference->exists()) {
            $fileURL = $imageReference->signedUrl($expiresAt);
        } else {
            $fileURL = '';
        }

        return $fileURL;

    }

    public function getSearchResult(): SearchResult
    {
        $url = 'tai-lieu/'.$this->id.'/'.$this->slug;
    
        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }

}
