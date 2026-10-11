<?php
namespace App\Http\Controllers;
use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use App\Services\AuditService;
class VehicleController extends Controller
{
    public function __construct(private AuditService $audit){}
    public function index(){return view('vehicles.index',['vehicles'=>Vehicle::orderBy('code')->paginate(12)]);}
    public function create(){abort_unless(auth()->user()->canManage(),403);return view('vehicles.form',['vehicle'=>new Vehicle]);}
    public function store(VehicleRequest $request){$v=Vehicle::create($request->validated());$this->audit->record('crear','vehiculo',$v->id);return redirect()->route('vehicles.index')->with('success','Vehículo registrado.');}
    public function edit(Vehicle $vehicle){abort_unless(auth()->user()->canManage(),403);return view('vehicles.form',compact('vehicle'));}
    public function update(VehicleRequest $request,Vehicle $vehicle){$vehicle->update($request->validated());$this->audit->record('actualizar','vehiculo',$vehicle->id);return redirect()->route('vehicles.index')->with('success','Vehículo actualizado.');}
}
