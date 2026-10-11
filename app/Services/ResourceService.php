<?php
namespace App\Services;
use App\Contracts\ResourceRepositoryInterface;
use App\Models\Resource;
use Illuminate\Validation\ValidationException;
class ResourceService
{
    public function __construct(private ResourceRepositoryInterface $repository, private AuditService $audit) {}
    public function create(array $data): Resource {
        $resource=$this->repository->create($data);
        $this->audit->record('crear','recurso',$resource->id,['code'=>$resource->code]);
        return $resource;
    }
    public function update(Resource $resource,array $data): Resource {
        // No reducir unidades por debajo de las que ya están prestadas.
        $loaned=(int) $resource->assignments()->whereNull('returned_at')->sum('quantity');
        if ((int)$data['quantity'] < $loaned) {
            throw ValidationException::withMessages(['quantity'=>'La cantidad no puede ser menor que las unidades actualmente asignadas.']);
        }
        $saved=$this->repository->update($resource,$data);
        $this->audit->record('actualizar','recurso',$saved->id,['code'=>$saved->code]);
        return $saved;
    }
    public function deactivate(Resource $resource): void {
        if ($resource->assignments()->whereNull('returned_at')->exists()) {
            throw ValidationException::withMessages(['resource'=>'Devuelve los equipos prestados antes de dar de baja este recurso.']);
        }
        $resource->update(['status'=>'baja']);
        $this->audit->record('dar_baja','recurso',$resource->id,['code'=>$resource->code]);
    }
}
