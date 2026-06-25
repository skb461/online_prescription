<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $primaryKey = 'doctors_id';

    protected $fillable = [
        'user_id', // Foreign key connecting to the users table
        'doctors_name',
        'doctors_designations',
        'doctors_phone_number',
        'doctors_gender',
        'doctors_address',
        'doctors_nationality',
        'doctors_nid',
        'doctors_type',
        'doctors_department',
        'doctors_speciality',
        'doctor_bmdc_registration_number',
        'doctors_status',
    ];
}