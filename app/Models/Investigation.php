<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Investigation extends Model
{
    protected $table      = 'investigations';
    protected $primaryKey = 'investigation_id';
    protected $fillable   = ['investigation_name', 'investigation_assigned_doctor_id', 'investigation_status'];
}