<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MedicineUnit extends Model
{
    protected $table      = 'medicine_units';
    protected $primaryKey = 'unit_id';
    protected $fillable   = ['unit_name', 'unit_status'];
}