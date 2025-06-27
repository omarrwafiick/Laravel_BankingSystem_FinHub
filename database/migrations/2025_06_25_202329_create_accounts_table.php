<?php

use App\Enums\AccountStatus;
use App\Enums\AccountType;
use App\Enums\Currency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) { 
            $table->id();
            $table->string('account_number')->unique(); 
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('balance',16, 4)->default(0); 
            $table->enum('type', array_column(AccountType::cases(), 'value'));
            $table->enum('currency', array_column(Currency::cases(), 'value'));
            $table->enum('status', array_column(AccountStatus::cases(), 'value'));
            $table->softDeletes();  
            $table->timestamps();
        }); 
    }
 
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
