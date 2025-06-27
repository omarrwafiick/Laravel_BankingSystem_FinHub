<?php

namespace App\Enums;

enum TransferStatus{
    case PENDING = 'pending';
    case COMPLETED = 'complete';
    case FAILED = 'failed'; 
}