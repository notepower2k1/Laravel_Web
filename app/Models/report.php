<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class report extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['description','identifier_id','userID','status','type_id'];


    public function types() {
        return $this->belongsTo(reportType::class,'type_id','id');
    }

    public function users() {
        return $this->belongsTo(User::class,'userID','id');
    }
}
