<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Assignment extends Model
{
    protected $fillable=['resource_id','user_id','recipient','quantity','assigned_at','returned_at','notes'];
    protected function casts(): array {return ['assigned_at'=>'datetime','returned_at'=>'datetime'];}
    public function resource(): BelongsTo {return $this->belongsTo(Resource::class);}
    public function user(): BelongsTo {return $this->belongsTo(User::class);}
}
