<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Complaint extends Model
{
    protected $table      = 'complaints';
    protected $primaryKey = 'complaint_id';
    protected $fillable   = ['complaint_name', 'complaint_assigned_doctor_id', 'complaint_status'];
}