<?php


namespace App\Enums;

enum AuditAction{
    case LOGIN = 'login';
    case LOGOUT = 'logout';
    case TRANSFER_ATTEMPT = 'transfer';
}