<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class VehicleRequest extends FormRequest
{
    public function authorize():bool{return (bool)$this->user()?->canManage();}
    public function rules():array{ $vehicle=$this->route('vehicle');return [
        'code'=>['required','string','max:30',Rule::unique('vehicles','code')->ignore($vehicle?->id)],
        'type'=>['required','string','max:80'], 'plate'=>['nullable','string','max:20'],
        'status'=>['required',Rule::in(['operativo','mantenimiento','inactivo'])],
        'mileage'=>['required','integer','min:0','max:10000000'],
        'next_maintenance_at'=>['nullable','date'], 'notes'=>['nullable','string','max:1000'],
    ]; }
}
