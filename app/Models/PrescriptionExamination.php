<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PrescriptionExamination extends Model
{
    protected $table      = 'prescription_examinations';
    protected $primaryKey = 'prescription_examination_id';
    protected $fillable   = ['prescription_id', 'examination_id', 'examination_value'];
    public function prescription(): BelongsTo { return $this->belongsTo(Prescription::class, 'prescription_id', 'prescription_id'); }
    public function examination(): BelongsTo { return $this->belongsTo(Examination::class, 'examination_id', 'examination_id'); }
}