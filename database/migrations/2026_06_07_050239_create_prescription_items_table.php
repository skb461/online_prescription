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
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            // Relates directly to the parent prescription record
            $table->foreignId('prescription_id')->constrained()->onDelete('cascade');
            
            // Specific medicine directions
            $table->string('medicine_name');
            $table->string('dosage');       // e.g., "1+0+1"
            $table->string('timing');       // e.g., "After Food"
            $table->string('duration');     // e.g., "14 days"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
    }
};