<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;
    protected $table = 'document_types';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['name','slug'];

    
    protected $appends = ['total'];

    public function getTotalAttribute()
    {
        $document = Document::where('type_id','=',$this->id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();

        return $document->count();
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }
}
