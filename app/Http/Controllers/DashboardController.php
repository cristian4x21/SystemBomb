<?php
namespace App\Http\Controllers;
use App\Models\Resource;
use App\Models\Assignment;
use App\Models\Vehicle;
class DashboardController extends Controller
{
    public function __invoke(){
        $resources=Resource::query()->where('status','!=','baja')->get();
        $expiring=$resources->filter(fn($r)=>$r->expires_at && $r->expires_at->between(today(),today()->addDays(30)));
        $low=$resources->filter(fn($r)=>$r->available <= $r->min_stock);
        return view('dashboard', [
            'resourcesCount'=>$resources->count(),
            'loanCount'=>Assignment::whereNull('returned_at')->count(),
            'vehicleCount'=>Vehicle::count(),
            'lowStock'=>$low,
            'expiring'=>$expiring,
            'recent'=>Assignment::with('resource')->latest()->limit(6)->get(),
        ]);
    }
}
