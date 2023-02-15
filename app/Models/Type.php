<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $table = 'types';
    protected $primaryKey = 'id';
    public $incrementing = false;

    //return $this->hasMany(Comment::class, 'foreign_key', 'local_key');
    //return $this->belongsTo(User::class, 'foreign_key', 'owner_key');

    public function books() {
        return $this->hasMany(Book::class);
    }
}
