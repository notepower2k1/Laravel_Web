<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentType extends Model
{
    use HasFactory;
    protected $table = 'comment_types';
    protected $primaryKey = 'id';
    public $incrementing = false;


   
}
