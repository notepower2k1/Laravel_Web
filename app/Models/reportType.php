<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reportType extends Model
{
    use HasFactory;
    protected $table = 'report_types';
    protected $primaryKey = 'id';
    public $incrementing = false;

    //return $this->hasMany(Comment::class, 'foreign_key', 'local_key');
    //return $this->belongsTo(User::class, 'foreign_key', 'owner_key');

    public function reports() {
        return $this->hasMany(report::class);
    }
}
