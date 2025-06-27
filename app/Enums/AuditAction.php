<?php


namespace App\Enums;

enum AuditAction{
    case LOGIN = 'login';
    case TRANSFER_ATTEMPT = 'transfer';
}