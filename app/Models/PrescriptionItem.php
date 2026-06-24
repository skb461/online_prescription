<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;

// class PrescriptionItem extends Model
// {
//     use HasFactory;

//     /**
//      * The attributes that are mass assignable.
//      */
//     protected $fillable = [
//         'prescription_id',
//         'medicine_name',
//         'dosage',
//         'timing',
//         'duration',
//     ];

//     /**
//      * Get the parent prescription metadata structure for this medicine.
//      */
//     public function prescription(): BelongsTo
//     {
//         return $this->belongsTo(Prescription::class);
//     }
// }



// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;

// class PrescriptionItem extends Model
// {
//     protected $fillable = ['prescription_id', 'medicine_name', 'dosage', 'timing', 'duration', 'instruction'];

//     public function prescription(): BelongsTo
//     {
//         return $this->belongsTo(Prescription::class);
//     }
// }



namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prescription extends Model
{
    // Ensure ALL dynamic fields are explicitly declared for mass assignment
    protected $fillable = [
        'patient_id', 
        'complaints', 
        'diagnoses', 
        'examinations', 
        'investigations', 
        'advices'
    ];

    // Ensure ALL json database columns are safely cast to PHP arrays
    protected $casts = [
        'complaints' => 'array',
        'diagnoses' => 'array',
        'examinations' => 'array',
        'investigations' => 'array',
        'advices' => 'array'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PrescriptionItem::class);
    }
}