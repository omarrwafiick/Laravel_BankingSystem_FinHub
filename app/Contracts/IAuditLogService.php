<?php

namespace App\Contracts;

use App\DTOs\AuditLogDto;
 
interface IAuditLogService{ 
    public function logAction(AuditLogDto $auditLogDto): void;
}