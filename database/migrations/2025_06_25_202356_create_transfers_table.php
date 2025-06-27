<?php

use App\Enums\AccountStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('sender_account_id')->constrained('accounts');
            $table->foreignId('recipient_account_id')->constrained('accounts');  
            $table->string('reference')->index('transfer_reference_index'); 
            $table->enum('status', allowed: array_column(AccountStatus::cases(), 'value')); 
            $table->decimal('amount',16,4); 
            $table->softDeletes();
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
