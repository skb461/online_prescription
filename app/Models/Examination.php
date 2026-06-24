<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Examination extends Model
{
    protected $table      = 'examinations';
    protected $primaryKey = 'examination_id';
    protected $fillable   = ['examination_name', 'examination_assigned_doctor_id', 'examination_status'];
}