<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteType extends Model
{
    use HasFactory;
    protected $table = 'note_types';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
