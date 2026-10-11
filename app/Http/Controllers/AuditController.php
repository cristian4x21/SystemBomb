<?php
namespace App\Http\Controllers;
use App\Models\AuditLog;
class AuditController extends Controller
{
    public function __invoke(){abort_unless(auth()->user()->role==='admin',403);return view('audits',['logs'=>AuditLog::with('user')->orderByDesc('created_at')->paginate(20)]);}
}
