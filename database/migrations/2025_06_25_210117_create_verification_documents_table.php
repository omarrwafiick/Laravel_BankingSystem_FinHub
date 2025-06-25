<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {
        Schema::create('verification_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('reviewed_by')->constrained('users');
            $table->string('file_path'); 
            $table->enum('type', ['NID', 'PASSPORT', 'UTILITY_BILL']);
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED']); 
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('verification_documents');
    }
};
