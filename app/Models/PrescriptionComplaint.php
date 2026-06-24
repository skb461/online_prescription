<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PrescriptionComplaint extends Model
{
    protected $table      = 'prescription_complaints';
    protected $primaryKey = 'prescription_complaint_id';
    protected $fillable   = ['prescription_id', 'complaint_id'];
    public function prescription(): BelongsTo { return $this->belongsTo(Prescription::class, 'prescription_id', 'prescription_id'); }
    public function complaint(): BelongsTo { return $this->belongsTo(Complaint::class, 'complaint_id', 'complaint_id'); }
}