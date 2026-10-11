<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AuditLog extends Model
{
    public $timestamps=false;
    protected $fillable=['user_id','action','model_type','model_id','details','created_at'];
    protected function casts():array{return ['created_at'=>'datetime','details'=>'array'];}
    public function user(){return $this->belongsTo(User::class);}
}
