<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $table = 'doctors_schedules';
    protected $primaryKey = 'doctors_schedule_id';

    protected $fillable = [
        'doctors_id',
        'doctors_visiting_time',
        'doctors_visiting_days',
        'doctors_visiting_fees_new',
        'doctors_visiting_fees_old',
        'doctors_schedule_status',
    ];
}