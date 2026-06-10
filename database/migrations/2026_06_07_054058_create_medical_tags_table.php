<?php
// database/migrations/xxxx_xx_xx_create_medical_tags_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('medical_tags', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'complaint', 'examination', 'advice', 'duration', 'instruction'
            $table->string('value_en'); // English rendering
            $table->string('value_bn')->nullable(); // Bangla rendering (e.g., 'খাবারের পরে')
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('medical_tags'); }
};