<?php
namespace App\Repositories;
use App\Contracts\ResourceRepositoryInterface;
use App\Models\Resource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
class EloquentResourceRepository implements ResourceRepositoryInterface
{
    public function paginate(string $search): LengthAwarePaginator {
        return Resource::query()->when($search !== '', fn($q) => $q->where(function ($q) use ($search) {
            $q->where('name','like', '%'.$search.'%')->orWhere('code','like','%'.$search.'%')
              ->orWhere('category','like','%'.$search.'%');
        }))->orderBy('name')->paginate(10)->withQueryString();
    }
    public function create(array $data): Resource { return Resource::create($data); }
    public function update(Resource $resource, array $data): Resource {$resource->update($data); return $resource->refresh();}
}
