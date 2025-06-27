<?php

namespace App\Contracts;

use App\DTOs\TransferDto; 
interface ITransferService{ 
    public function createTransfer(TransferDto $transferDto):int;
}