<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loginHistory extends Model
{
    use HasFactory;
    protected $table = 'login_histories';
    protected $primaryKey = 'id';
    public  $timestamps = true;
    public $incrementing = false;

    protected $fillable = ['userID'];

    public function users() {
        return $this->belongsTo(User::class,'userCreatedID','id');
    }

}
