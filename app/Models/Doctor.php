<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Doctor extends Model
{
    protected $table      = 'doctors';
    protected $primaryKey = 'doctors_id';
    protected $fillable   = ['doctors_name', 'doctors_designations', 'doctors_image', 'doctors_signature', 'doctors_phone_number', 'doctors_gender', 'doctors_address', 'doctors_nationality', 'doctors_nid', 'doctors_type', 'doctors_department', 'doctors_speciality', 'doctor_bmdc_registration_number', 'doctors_status'];
    public function prescriptions(): HasMany { return $this->hasMany(Prescription::class, 'prescription_assigned_doctor_id', 'doctors_id'); }
}