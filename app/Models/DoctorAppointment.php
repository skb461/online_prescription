<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAppointment extends Model
{
    use HasFactory;

    protected $table = 'doctors_appointments';
    protected $primaryKey = 'appointment_id';

    protected $fillable = [
        'patient_id',
        'doctors_id',
        'appointment_date',
        'appointment_status', // 1=Pending, 2=Confirmed, 3=Cancelled
    ];

    /**
     * Relationship back to the Patient.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    /**
     * Relationship back to the Doctor.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctors_id', 'doctors_id');
    }
}