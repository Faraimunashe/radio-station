<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleEngineer extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'engineer_id'
    ];
}
