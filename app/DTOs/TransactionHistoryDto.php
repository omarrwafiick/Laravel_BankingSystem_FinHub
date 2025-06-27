<?php

namespace App\DTOs;

use App\Http\Requests\TransactionHistoryRequest;
use Carbon\Carbon;
  

class TransactionHistoryDto
{
    public string $account_number;
    public Carbon $from;
    public Carbon $to;
    public string $category;
    
    public static function fromRequestToDto(TransactionHistoryRequest $request): self
    {
        $dto = new self(); 
        $dto->account_number = $request->input("account_number"); 
        $dto->from = $request->input("from");
        $dto->to = $request->input("to");    
        $dto->category = $request->input("category");   
        return $dto;
    }
}