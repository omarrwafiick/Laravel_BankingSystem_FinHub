<?php

namespace App\Events;
 
use App\DTOs\TransferDto;
use App\Models\Account;
use Illuminate\Broadcasting\InteractsWithSockets; 
use Illuminate\Broadcasting\PrivateChannel; 
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransferEvent
{ 
    use Dispatchable, InteractsWithSockets, SerializesModels;
 
    public function __construct(public TransferDto $transferDto, public Account $sender, public Account $recipient)
    { 
    }
 
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('transfer-event'),
        ];
    }
}
