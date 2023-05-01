<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class downloadingHistory extends Model
{
    use HasFactory;
    protected $table = 'downloading_histories';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['documentID','total','userID'];


    public function documents() {
        return $this->belongsTo(Document::class,'documentID','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }
}
