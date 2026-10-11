<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AssignmentRequest extends FormRequest
{
    public function authorize(): bool{return (bool)$this->user()?->canManage();}
    public function rules(): array {return [
        'resource_id'=>['required','integer','exists:resources,id'],
        'recipient'=>['required','string','max:150'],
        'quantity'=>['required','integer','min:1','max:10000'],
        'notes'=>['nullable','string','max:1000'],
    ];}
}
