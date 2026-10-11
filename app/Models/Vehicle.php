<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Vehicle extends Model
{
    protected $fillable=['code','type','plate','status','mileage','next_maintenance_at','notes'];
    protected function casts(): array {return ['next_maintenance_at'=>'date'];}
}
