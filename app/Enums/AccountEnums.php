<?php

namespace App\Enums;

enum AccountStatus: string  {
    case ACTIVE = 'active';
    case FROZEN = 'frozen';
    case CLOSED = 'closed';
}

enum Currency: string  {
    case USD = 'USD';
    case EGP = 'EGP'; 
}

enum AccountType: string  {
    case SAVINGS = 'savings';
    case CHECKING = 'checking'; 
    case LOAN = 'loan';  
}