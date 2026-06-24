<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PrescriptionLog extends Model
{
    protected $table      = 'prescription_logs';
    protected $primaryKey = 'prescription_log_id';
    protected $fillable   = ['prescription_id', 'doctors_id', 'patient_id', 'prescription_date', 'previous_prescription_id', 'prescription_log_status'];
    public function prescription(): BelongsTo { return $this->belongsTo(Prescription::class, 'prescription_id', 'prescription_id'); }
    public function previousPrescription(): BelongsTo { return $this->belongsTo(Prescription::class, 'previous_prescription_id', 'prescription_id'); }
    public function doctor(): BelongsTo { return $this->belongsTo(Doctor::class, 'doctors_id', 'doctors_id'); }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class, 'patient_id', 'patient_id'); }
}