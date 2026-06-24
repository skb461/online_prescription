<?php
// namespace App\Models;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\HasMany;
// class Patient extends Model
// {
//     protected $table      = 'patients';
//     protected $primaryKey = 'patient_id';
//     protected $fillable   = ['patient_name', 'patient_age', 'patient_gender', 'patient_phone_number', 'patient_division', 'patient_district', 'patient_union_village', 'patient_status'];
//     public function prescriptions(): HasMany { return $this->hasMany(Prescription::class, 'prescription_for_patient_id', 'patient_id'); }
// }


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    // Setting custom primary key
    protected $primaryKey = 'patient_id';

    // Attributes that can be mass-assigned
    protected $fillable = [
        'patient_name',
        'patient_age',
        'patient_gender',
        'patient_phone_number',
        'patient_division',
        'patient_district',
        'patient_union_village',
        'patient_status',
    ];
}