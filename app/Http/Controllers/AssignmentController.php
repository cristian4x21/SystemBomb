<?php
namespace App\Http\Controllers;
use App\Http\Requests\AssignmentRequest;
use App\Models\Assignment;
use App\Models\Resource;
use App\Services\AssignmentService;
class AssignmentController extends Controller
{
    public function __construct(private AssignmentService $service){}
    public function index(){return view('assignments.index',['assignments'=>Assignment::with(['resource','user'])->latest()->paginate(12)]);}
    public function create(){abort_unless(auth()->user()->canManage(),403);return view('assignments.form',['resources'=>Resource::where('status','disponible')->orderBy('name')->get()]);}
    public function store(AssignmentRequest $request){$this->service->create($request->validated());return redirect()->route('assignments.index')->with('success','Asignación registrada.');}
    public function return(Assignment $assignment){abort_unless(auth()->user()->canManage(),403);$this->service->return($assignment);return back()->with('success','Devolución registrada.');}
}
