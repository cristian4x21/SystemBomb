<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ResourceRequest extends FormRequest
{
    public function authorize(): bool {return (bool)$this->user()?->canManage();}
    public function rules():array {
        $resource=$this->route('resource');
        return [
            'code'=>['required','string','max:30',Rule::unique('resources','code')->ignore($resource?->id)],
            'name'=>['required','string','max:150'],
            'category'=>['required',Rule::in(['EPP','Herramientas','Mangueras','Insumos médicos','Otros'])],
            'location'=>['required','string','max:100'],
            'status'=>['required',Rule::in(['disponible','mantenimiento','baja'])],
            'quantity'=>['required','integer','min:0','max:1000000'],
            'min_stock'=>['required','integer','min:0','max:1000000'],
            'expires_at'=>['nullable','date'],
            'notes'=>['nullable','string','max:1000'],
        ];
    }
}
