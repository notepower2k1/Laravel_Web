<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['displayName','avatar','gender','userID'];

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        $expiresAt = new \DateTime('tomorrow');
        $firebase_storage_path = 'avatarImage/';       
        $imageReference = app('firebase.storage')->getBucket()->object($firebase_storage_path.$this->avatar);

        if ($imageReference->exists()) {
            $imageURL = $imageReference->signedUrl($expiresAt);
        } else {
            $imageURL = '';
        }
        return $imageURL;
    }

   
}
