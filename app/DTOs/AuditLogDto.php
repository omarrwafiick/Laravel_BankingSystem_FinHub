<?php

namespace App\DTOs;
 
  

class AuditLogDto
{    
    public int $user_id;
    public string $action;
   
    public static function dtoObj(int $user_id, string $action): self{
        $dto = new self();
        $dto->user_id = $user_id;
        $dto->action = $action;
        return $dto;
    }
}