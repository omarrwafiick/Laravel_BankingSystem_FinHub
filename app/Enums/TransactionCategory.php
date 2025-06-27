<?php

namespace App\Enums;

enum TransactionCategory{
    case WITHDRAW = 'withdraw';
    case DEPOSIT = 'deposit';
    case TRANSFER_IN = 'transferin';
    case TRANSFER_OUT = 'transferout'; 
}