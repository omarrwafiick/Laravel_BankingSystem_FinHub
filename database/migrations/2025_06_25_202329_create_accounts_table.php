<?php

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
            $table->enum('type', ['SAVINGS', 'CHECKING', 'LOAN']);  
            $table->enum('currency', ['USD', 'EGP']);  ; 
            $table->enum('status', ['ACTIVE', 'FROZEN', 'CLOSED']);
            $table->softDeletes();  
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
