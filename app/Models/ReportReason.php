<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportReason extends Model
{
    use HasFactory;
    protected $table = 'report_reasons';
    protected $primaryKey = 'id';
    public $incrementing = false;


    public function reports() {
        return $this->hasMany(report::class);
    }
}


