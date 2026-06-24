<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrescriptionDiagnosis extends Model
{
    protected $table      = 'prescription_diagnoses';   // explicit
    protected $primaryKey = 'prescription_diagnosis_id';

    protected $fillable = [
        'prescription_id',
        'diagnosis_id',
    ];

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class, 'prescription_id', 'prescription_id');
    }

    public function diagnosis(): BelongsTo
    {
        return $this->belongsTo(Diagnosis::class, 'diagnosis_id', 'diagnosis_id');
    }
}