<?php

namespace App\DTOs;
  

class TransferResultDto
{
    private int $transferId;
    private int $userId;
    private bool $isDesposit;
    public static function makeDto(int $transferId, int $userId,  bool $isDesposit): TransferResultDto{
        $dto = new self();
        $dto->transferId = $transferId;
        $dto->userId = $userId;
        $dto->isDesposit = $isDesposit;
        return $dto;
    }
}