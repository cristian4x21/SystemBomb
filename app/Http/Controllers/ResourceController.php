<?php
namespace App\Http\Controllers;
use App\Contracts\ResourceRepositoryInterface;
use App\Http\Requests\ResourceRequest;
use App\Models\Resource;
use App\Services\ResourceService;
use Illuminate\Http\Request;
class ResourceController extends Controller
{
    public function __construct(private ResourceRepositoryInterface $repository, private ResourceService $service) {}
    public function index(Request $request){return view('resources.index', ['resources'=>$this->repository->paginate(trim((string)$request->query('q',''))),'q'=>$request->query('q','')]);}
    public function create(){abort_unless(auth()->user()->canManage(),403);return view('resources.form',['resource'=>new Resource]);}
    public function store(ResourceRequest $request){$this->service->create($request->validated());return redirect()->route('resources.index')->with('success','Recurso registrado.');}
    public function edit(Resource $resource){abort_unless(auth()->user()->canManage(),403);return view('resources.form',compact('resource'));}
    public function update(ResourceRequest $request,Resource $resource){$this->service->update($resource,$request->validated());return redirect()->route('resources.index')->with('success','Recurso actualizado.');}
    public function destroy(Resource $resource){abort_unless(auth()->user()->role==='admin',403);$this->service->deactivate($resource);return back()->with('success','Recurso dado de baja (se conserva su historial).');}
}
