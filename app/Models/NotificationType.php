<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    use HasFactory;
    protected $table = 'notification_types';
    protected $primaryKey = 'id';
    public $incrementing = false;


}
