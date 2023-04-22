<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class previewDocumentImages extends Model
{
    use HasFactory;
    protected $table = 'preview_document_images';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['image','documentID'];

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        $expiresAt = new \DateTime('tomorrow');
        $firebase_storage_path = 'documentPreviewImage/';       
        $imageReference = app('firebase.storage')->getBucket()->object($firebase_storage_path.$this->image);

        if ($imageReference->exists()) {
            $imageURL = $imageReference->signedUrl($expiresAt);
        } else {
            $imageURL = '';
        }
        return $imageURL;
    }

   
    public function documents() {
        return $this->belongsTo(Document::class,'documentID','id');
    }

 
}
