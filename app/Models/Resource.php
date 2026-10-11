<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Resource extends Model
{
    protected $fillable = ['code','name','category','location','status','quantity','min_stock','expires_at','notes'];
    protected function casts(): array { return ['expires_at'=>'date']; }
    public function assignments(): HasMany { return $this->hasMany(Assignment::class); }
    public function getAvailableAttribute(): int {
        return max(0, (int) $this->quantity - (int) $this->assignments()->whereNull('returned_at')->sum('quantity'));
    }
}
