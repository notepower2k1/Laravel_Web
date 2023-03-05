<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table = 'documents';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;   

    protected $fillable = ['name', 
    'description' ,'slug','type_id','image','userCreatedID','isPublic','isCompleted','language','file','author','extension'];


    public function types() {
        return $this->belongsTo(DocumentType::class,'type_id','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userCreatedID','id');
    }

}
