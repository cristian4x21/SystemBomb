<?php
namespace App\Services;
use App\Models\AuditLog;
class AuditService
{
    public function record(string $action, string $model, int $id, array $details=[]): void {
        AuditLog::create(['user_id'=>auth()->id(), 'action'=>$action,'model_type'=>$model,
            'model_id'=>$id,'details'=>$details, 'created_at'=>now()]);
    }
}
