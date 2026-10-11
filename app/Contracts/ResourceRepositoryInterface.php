<?php
namespace App\Contracts;
use App\Models\Resource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
interface ResourceRepositoryInterface
{
    public function paginate(string $search): LengthAwarePaginator;
    public function create(array $data): Resource;
    public function update(Resource $resource, array $data): Resource;
}
