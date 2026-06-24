<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Prescription extends Model
{
    protected $table      = 'prescriptions';
    protected $primaryKey = 'prescription_id';
    protected $fillable   = ['prescription_for_patient_id', 'prescription_assigned_doctor_id', 'prescription_date', 'next_meeting_date', 'prescription_status'];
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class, 'prescription_for_patient_id', 'patient_id'); }
    public function doctor(): BelongsTo { return $this->belongsTo(Doctor::class, 'prescription_assigned_doctor_id', 'doctors_id'); }
    public function complaints(): HasMany { return $this->hasMany(PrescriptionComplaint::class, 'prescription_id', 'prescription_id'); }
    public function examinations(): HasMany { return $this->hasMany(PrescriptionExamination::class, 'prescription_id', 'prescription_id'); }
    public function diagnoses(): HasMany { return $this->hasMany(PrescriptionDiagnosis::class, 'prescription_id', 'prescription_id'); }
    public function investigations(): HasMany { return $this->hasMany(PrescriptionInvestigation::class, 'prescription_id', 'prescription_id'); }
    public function advices(): HasMany { return $this->hasMany(PrescriptionAdvice::class, 'prescription_id', 'prescription_id'); }
    public function medicines(): HasMany { return $this->hasMany(PrescriptionMedicine::class, 'prescription_id', 'prescription_id'); }
    public function doseDurations(): HasMany { return $this->hasMany(PrescriptionMedicineDoseDuration::class, 'prescription_id', 'prescription_id'); }
    public function logs(): HasMany { return $this->hasMany(PrescriptionLog::class, 'prescription_id', 'prescription_id'); }
}