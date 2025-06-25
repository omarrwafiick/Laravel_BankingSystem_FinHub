<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->index('transaction_reference_index');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('transfer_id')->constrained('transfers');
            $table->decimal('amount',16,4); 
            $table->decimal('balance_before',16,4);
            $table->decimal('balance_after',16,4);
            $table->enum('category', ['WITHDRAW', 'DEPOSIT','TRANSFER_IN', 'TRANSFER_OUT']);;  
            $table->boolean('confirmed')->default(false); 
            $table->string('description')->nullable();
            $table->text('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
