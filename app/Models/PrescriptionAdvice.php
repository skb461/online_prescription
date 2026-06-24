<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrescriptionAdvice extends Model
{
    protected $table      = 'prescription_advices';   // ← FIX: Laravel guesses 'prescription_advice'
    protected $primaryKey = 'prescription_advice_id';

    protected $fillable = [
        'prescription_id',
        'advice_id',
    ];

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class, 'prescription_id', 'prescription_id');
    }

    public function advice(): BelongsTo
    {
        return $this->belongsTo(Advice::class, 'advice_id', 'advice_id');
    }
}