<?php

namespace App\Http\Controllers;

use App\DTOs\AuditLogDto;
use App\DTOs\DepositDto; 
use App\DTOs\TransactionHistoryDto;
use App\DTOs\TransferDto;
use App\DTOs\WithDrawDto;
use App\Enums\AuditAction;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransactionHistoryRequest;
use App\Http\Requests\TransferRequest;
use App\Http\Requests\WithDrawRequest;
use App\Services\AccountService;
use App\Services\AuditLogService;
use App\Services\TransactionService; 

class TransactionController extends Controller
{
    public function __construct(
        private readonly AccountService $account_service, 
        private readonly TransactionService $transactionService,
        private readonly AuditLogService $auditLogService
    )
    {}

    public function deposite(DepositRequest $request){
        $depositDto = DepositDto::fromRequestToDto($request);
        $transactionDto = $this->account_service->deposit($depositDto);
        $auditDto = AuditLogDto::dtoObj(AuditAction::TRANSFER_ATTEMPT->value, $transactionDto->user_id);
        $this->auditLogService->logAction($auditDto);
        return $this->sendSuccess(['transaction_reference'=> $transactionDto->reference],"Deposit was processed successfully");
    }   

    public function withdraw(WithDrawRequest $request){
        $withDrawDto = WithDrawDto::fromRequestToDto($request);
        $transactionDto = $this->account_service->withdraw($withDrawDto);
        $auditDto = AuditLogDto::dtoObj(AuditAction::TRANSFER_ATTEMPT->value, $transactionDto->user_id);
        $this->auditLogService->logAction($auditDto);
        return $this->sendSuccess(['transaction_reference'=> $transactionDto->reference],"WithDraw was processed successfully");
    }   

    public function transfer(TransferRequest $request){
        $transferDto = TransferDto::fromRequestToDto($request);
        $this->account_service->transfer($transferDto);
        $auditDto = AuditLogDto::dtoObj(AuditAction::TRANSFER_ATTEMPT->value, $transferDto->sender_account_id);
        $this->auditLogService->logAction($auditDto);
        return $this->sendSuccess([],"Transfer was processed successfully");
    }   

    public function transactionHistory(TransactionHistoryRequest $request){
        $dto = TransactionHistoryDto::fromRequestToDto($request);
        $result = $this->transactionService->transactionHistory($dto->account_number, $dto->category, $dto->from, $dto->to);
        return $this->sendSuccess([...$result],"");
    }   
}
