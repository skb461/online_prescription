<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Medicine extends Model
{
    protected $table      = 'medicines';
    protected $primaryKey = 'medicine_id';
    protected $fillable   = ['medicine_name', 'medicine_generic_name', 'medicine_brand_name', 'medicine_type', 'medicine_power', 'medicine_status'];
}