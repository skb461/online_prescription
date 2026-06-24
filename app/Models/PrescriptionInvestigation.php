<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PrescriptionInvestigation extends Model
{
    protected $table      = 'prescription_investigations';
    protected $primaryKey = 'prescription_investigation_id';
    protected $fillable   = ['prescription_id', 'investigation_id', 'investigation_value'];
    public function prescription(): BelongsTo { return $this->belongsTo(Prescription::class, 'prescription_id', 'prescription_id'); }
    public function investigation(): BelongsTo { return $this->belongsTo(Investigation::class, 'investigation_id', 'investigation_id'); }
}