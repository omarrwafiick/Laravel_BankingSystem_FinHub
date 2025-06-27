<?php
 
namespace App\Services;

use App\Contracts\IAuditLogService;
use App\DTOs\AuditLogDto; 
use App\Models\AuditLog;
 

class AuditLogService implements IAuditLogService{
    public function logAction(AuditLogDto $auditLogDto): void{
        AuditLog::create([
            'user_id' => $auditLogDto->user_id,
            'action' => $auditLogDto->action 
        ]); 
    } 

}