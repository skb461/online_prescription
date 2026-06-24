<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PrescriptionMedicine extends Model
{
    protected $table      = 'prescription_medicines';
    protected $primaryKey = 'prescription_medicine_id';
    protected $fillable   = ['prescription_id', 'medicine_id', 'medicine_meal_relation', 'medicine_instructions'];
    public function prescription(): BelongsTo { return $this->belongsTo(Prescription::class, 'prescription_id', 'prescription_id'); }
    public function medicine(): BelongsTo { return $this->belongsTo(Medicine::class, 'medicine_id', 'medicine_id'); }
}