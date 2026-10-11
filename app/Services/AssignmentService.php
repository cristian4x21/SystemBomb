<?php
namespace App\Services;
use App\Models\Assignment;
use App\Models\Resource;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class AssignmentService
{
    public function __construct(private AuditService $audit) {}
    public function create(array $data): Assignment {
        return DB::transaction(function () use ($data) {
            // lockForUpdate impide prestar el mismo stock simultáneamente.
            $resource = Resource::query()->lockForUpdate()->findOrFail($data['resource_id']);
            $occupied=(int)$resource->assignments()->whereNull('returned_at')->sum('quantity');
            $available=(int)$resource->quantity-$occupied;
            if($resource->status!=='disponible' || $resource->expires_at?->isPast() || $available < $data['quantity']) {
                throw ValidationException::withMessages(['resource_id'=>'Recurso no disponible, vencido o con stock insuficiente.']);
            }
            $assignment=Assignment::create([
                ...$data,'user_id'=>auth()->id(),'assigned_at'=>now(),'returned_at'=>null,
            ]);
            $this->audit->record('prestar','asignacion',$assignment->id,['resource_id'=>$resource->id,'quantity'=>$assignment->quantity]);
            return $assignment;
        });
    }
    public function return(Assignment $assignment): void {
        DB::transaction(function () use ($assignment) {
            $locked=Assignment::query()->lockForUpdate()->findOrFail($assignment->id);
            if($locked->returned_at!==null) {
                throw ValidationException::withMessages(['assignment'=>'Esta asignación ya fue devuelta.']);
            }
            $locked->update(['returned_at'=>now()]);
            $this->audit->record('devolver','asignacion',$locked->id);
        });
    }
}
