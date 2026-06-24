<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PrescriptionMedicineDoseDuration extends Model
{
    protected $table      = 'prescription_medicine_dose_durations';
    protected $primaryKey = 'prescription_medicine_dose_duration_id';
    protected $fillable   = ['prescription_id', 'medicine_dose', 'medicine_unit_id', 'medicine_duration'];
    public function prescription(): BelongsTo { return $this->belongsTo(Prescription::class, 'prescription_id', 'prescription_id'); }
    public function unit(): BelongsTo { return $this->belongsTo(MedicineUnit::class, 'medicine_unit_id', 'unit_id'); }
}