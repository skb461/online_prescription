<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            // Automatically maps to 'id' on your 'users' table (the doctor or admin creating it)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            // Automatically maps to 'id' on the 'patients' table
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            
            // Medical Data Fields
            $table->text('chief_complaints'); // Reason for patient visit
            $table->string('blood_pressure', 20)->nullable();
            $table->string('weight', 10)->nullable();
            $table->text('medical_history')->nullable();
            $table->text('advice')->nullable(); // General doctor tips
            $table->date('next_follow_up')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};