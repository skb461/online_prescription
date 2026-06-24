<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $table      = 'diagnoses';   // explicit — Laravel knows this but being safe
    protected $primaryKey = 'diagnosis_id';

    protected $fillable = [
        'diagnosis_name',
        'diagnosis_assigned_doctor_id',
        'diagnosis_status',
    ];
}