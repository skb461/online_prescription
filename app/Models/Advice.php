<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advice extends Model
{
    protected $table      = 'advices';   // ← FIX: Laravel guesses 'advice' (uncountable noun)
    protected $primaryKey = 'advice_id';

    protected $fillable = [
        'advice_name',
        'advice_assigned_doctor_id',
        'advice_status',
    ];
}