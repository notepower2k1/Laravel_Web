<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $table = 'follows';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['identifier_id','type_id','userID'];

    protected $appends = ['time','identifier'];

    public function getTimeAttribute()
    {
        Carbon::setLocale('vi'); 

        $dt = new Carbon($this->updated_at);
        $now = Carbon::now();

        return $dt->diffForHumans($now);
    }

    public function getIdentifierAttribute()
    {
        $option = $this->type_id;
        $identifier = collect();

        switch ($option) {
            case 1:
                $identifier = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->findOrFail($this->identifier_id);
                break;
            case 2:
                $identifier = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->findOrFail($this->identifier_id);        
                break;
            default:
                $identifier = collect();
        }
        
        return $identifier;

    }


    public function users()
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
}