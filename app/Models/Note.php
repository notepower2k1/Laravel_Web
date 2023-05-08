<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $table = 'notes';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;   

    protected $fillable = ['content','identifier_id' ,'type_id'];
    protected $appends = ['identifier'];

    public function getIdentifierAttribute()
    {
        $option = $this->type_id;
        $identifier = collect();


        switch ($option) {
            case 1:
                $identifier = Book::findOrFail($this->identifier_id);        

                break;
            case 2:
                $identifier = Document::findOrFail($this->identifier_id);

                break;
            case 3:
                $identifier = User::findOrFail($this->identifier_id);  
        
                break;
            case 3:
                $identifier = ForumPosts::findOrFail($this->identifier_id);  
        
                break;
            default:
                $identifier = collect();
        }
        
        return $identifier;

    }

    public function types() {
        return $this->belongsTo(NoteType::class,'type_id','id');
    }

}
