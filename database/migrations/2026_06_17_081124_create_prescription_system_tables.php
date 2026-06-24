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
        // ─────────────────────────────────────────────
        // 1. PATIENTS
        // ─────────────────────────────────────────────
        Schema::create('patients', function (Blueprint $table) {
            $table->id('patient_id');
            $table->string('patient_name');
            $table->unsignedTinyInteger('patient_age')->nullable();
            $table->enum('patient_gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('patient_phone_number', 20)->nullable();
            $table->string('patient_division')->nullable();
            $table->string('patient_district')->nullable();
            $table->string('patient_union_village')->nullable();
            $table->tinyInteger('patient_status')->default(1)->comment('1=Active, 0=Inactive');
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 2. DOCTORS
        // ─────────────────────────────────────────────
        Schema::create('doctors', function (Blueprint $table) {
            $table->id('doctors_id');
            $table->string('doctors_name');
            $table->string('doctors_designations')->nullable();
            $table->string('doctors_image')->nullable();
            $table->string('doctors_signature')->nullable();
            $table->string('doctors_phone_number', 20)->nullable();
            $table->enum('doctors_gender', ['Male', 'Female', 'Other'])->nullable();
            $table->text('doctors_address')->nullable();
            $table->string('doctors_nationality')->nullable();
            $table->string('doctors_nid', 30)->nullable();
            $table->enum('doctors_type', ['Permanent', 'Guest'])->default('Permanent');
            $table->string('doctors_department')->nullable();
            $table->string('doctors_speciality')->nullable();
            $table->string('doctor_bmdc_registration_number', 50)->nullable()->unique();
            $table->tinyInteger('doctors_status')->default(1)->comment('1=Active, 0=Inactive');
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 3. DOCTORS SCHEDULE
        // ─────────────────────────────────────────────
        Schema::create('doctors_schedules', function (Blueprint $table) {
            $table->id('doctors_schedule_id');
            $table->foreignId('doctors_id')->constrained('doctors', 'doctors_id')->onDelete('cascade');
            $table->time('doctors_visiting_time')->nullable();
            $table->string('doctors_visiting_days')->nullable()->comment('e.g. Sat,Sun,Mon');
            $table->decimal('doctors_visiting_fees_new', 10, 2)->default(0)->comment('New patient fee');
            $table->decimal('doctors_visiting_fees_old', 10, 2)->default(0)->comment('Old patient fee');
            $table->tinyInteger('doctors_schedule_status')->default(1);
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 4. DOCTORS ASSISTANTS
        // ─────────────────────────────────────────────
        Schema::create('doctors_assistants', function (Blueprint $table) {
            $table->id('doctors_assistant_id');
            $table->string('doctors_assistant_name');
            $table->string('doctors_assistant_phone_number', 20)->nullable();
            $table->text('doctors_assistant_address')->nullable();
            $table->enum('doctors_assistant_gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('doctors_assistant_nationality')->nullable();
            $table->string('doctors_assistant_nid', 30)->nullable();
            $table->string('doctors_assistant_image')->nullable();
            $table->foreignId('doctors_assistant_doctors_id')->constrained('doctors', 'doctors_id')->onDelete('cascade');
            $table->date('doctors_assistant_date')->nullable();
            $table->tinyInteger('doctors_assistant_status')->default(1);
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 5. MEDICINES
        // ─────────────────────────────────────────────
        Schema::create('medicines', function (Blueprint $table) {
            $table->id('medicine_id');
            $table->string('medicine_name');
            $table->string('medicine_generic_name')->nullable();
            $table->string('medicine_brand_name')->nullable();
            $table->enum('medicine_type', ['Tablet', 'Capsule', 'Syrup', 'Solution', 'Injection', 'Cream', 'Drop'])->nullable();
            $table->string('medicine_power', 50)->nullable()->comment('e.g. 500mg, 1000mg');
            $table->tinyInteger('medicine_status')->default(1);
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 6. MEDICINE UNITS
        // ─────────────────────────────────────────────
        Schema::create('medicine_units', function (Blueprint $table) {
            $table->id('unit_id');
            $table->string('unit_name', 50);
            $table->tinyInteger('unit_status')->default(1);
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 7. PATIENT COMPLAINTS (master list)
        // ─────────────────────────────────────────────
        Schema::create('complaints', function (Blueprint $table) {
            $table->id('complaint_id');
            $table->string('complaint_name');
            $table->foreignId('complaint_assigned_doctor_id')->nullable()->constrained('doctors', 'doctors_id')->nullOnDelete();
            $table->tinyInteger('complaint_status')->default(1);
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 8. PATIENT EXAMINATIONS (master list)
        // ─────────────────────────────────────────────
        Schema::create('examinations', function (Blueprint $table) {
            $table->id('examination_id');
            $table->string('examination_name');
            $table->foreignId('examination_assigned_doctor_id')->nullable()->constrained('doctors', 'doctors_id')->nullOnDelete();
            $table->tinyInteger('examination_status')->default(1);
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 9. PATIENT DIAGNOSES (master list)
        // ─────────────────────────────────────────────
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id('diagnosis_id');
            $table->string('diagnosis_name');
            $table->foreignId('diagnosis_assigned_doctor_id')->nullable()->constrained('doctors', 'doctors_id')->nullOnDelete();
            $table->tinyInteger('diagnosis_status')->default(1);
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 10. PATIENT INVESTIGATIONS (master list)
        // ─────────────────────────────────────────────
        Schema::create('investigations', function (Blueprint $table) {
            $table->id('investigation_id');
            $table->string('investigation_name');
            $table->foreignId('investigation_assigned_doctor_id')->nullable()->constrained('doctors', 'doctors_id')->nullOnDelete();
            $table->tinyInteger('investigation_status')->default(1);
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 11. PATIENT ADVICE (master list)
        // ─────────────────────────────────────────────
        Schema::create('advices', function (Blueprint $table) {
            $table->id('advice_id');
            $table->string('advice_name');
            $table->foreignId('advice_assigned_doctor_id')->nullable()->constrained('doctors', 'doctors_id')->nullOnDelete();
            $table->tinyInteger('advice_status')->default(1);
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 12. PRESCRIPTIONS
        // ─────────────────────────────────────────────
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id('prescription_id');
            $table->foreignId('prescription_for_patient_id')->constrained('patients', 'patient_id')->onDelete('cascade');
            $table->foreignId('prescription_assigned_doctor_id')->constrained('doctors', 'doctors_id')->onDelete('cascade');
            $table->date('prescription_date');
            $table->date('next_meeting_date')->nullable();
            $table->tinyInteger('prescription_status')->default(1);
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 13. PRESCRIPTION LOG
        // ─────────────────────────────────────────────
        Schema::create('prescription_logs', function (Blueprint $table) {
            $table->id('prescription_log_id');
            $table->foreignId('prescription_id')->constrained('prescriptions', 'prescription_id')->onDelete('cascade');
            $table->foreignId('doctors_id')->constrained('doctors', 'doctors_id')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients', 'patient_id')->onDelete('cascade');
            $table->date('prescription_date');
            $table->foreignId('previous_prescription_id')->nullable()->constrained('prescriptions', 'prescription_id')->nullOnDelete();
            $table->tinyInteger('prescription_log_status')->default(1);
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 14. PRESCRIPTION COMPLAINTS (pivot)
        // ─────────────────────────────────────────────
        Schema::create('prescription_complaints', function (Blueprint $table) {
            $table->id('prescription_complaint_id');
            $table->foreignId('prescription_id')->constrained('prescriptions', 'prescription_id')->onDelete('cascade');
            $table->foreignId('complaint_id')->constrained('complaints', 'complaint_id')->onDelete('cascade');
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 15. PRESCRIPTION EXAMINATIONS (pivot)
        // ─────────────────────────────────────────────
        Schema::create('prescription_examinations', function (Blueprint $table) {
            $table->id('prescription_examination_id');
            $table->foreignId('prescription_id')->constrained('prescriptions', 'prescription_id')->onDelete('cascade');
            $table->foreignId('examination_id')->constrained('examinations', 'examination_id')->onDelete('cascade');
            $table->string('examination_value')->nullable();
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 16. PRESCRIPTION DIAGNOSES (pivot)
        // ─────────────────────────────────────────────
        Schema::create('prescription_diagnoses', function (Blueprint $table) {
            $table->id('prescription_diagnosis_id');
            $table->foreignId('prescription_id')->constrained('prescriptions', 'prescription_id')->onDelete('cascade');
            $table->foreignId('diagnosis_id')->constrained('diagnoses', 'diagnosis_id')->onDelete('cascade');
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 17. PRESCRIPTION INVESTIGATIONS (pivot)
        // ─────────────────────────────────────────────
        Schema::create('prescription_investigations', function (Blueprint $table) {
            $table->id('prescription_investigation_id');
            $table->foreignId('prescription_id')->constrained('prescriptions', 'prescription_id')->onDelete('cascade');
            $table->foreignId('investigation_id')->constrained('investigations', 'investigation_id')->onDelete('cascade');
            $table->string('investigation_value')->nullable();
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 18. PRESCRIPTION ADVICE (pivot)
        // ─────────────────────────────────────────────
        Schema::create('prescription_advices', function (Blueprint $table) {
            $table->id('prescription_advice_id');
            $table->foreignId('prescription_id')->constrained('prescriptions', 'prescription_id')->onDelete('cascade');
            $table->foreignId('advice_id')->constrained('advices', 'advice_id')->onDelete('cascade');
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 19. PRESCRIPTION MEDICINES (pivot)
        // ─────────────────────────────────────────────
        Schema::create('prescription_medicines', function (Blueprint $table) {
            $table->id('prescription_medicine_id');
            $table->foreignId('prescription_id')->constrained('prescriptions', 'prescription_id')->onDelete('cascade');
            $table->foreignId('medicine_id')->constrained('medicines', 'medicine_id')->onDelete('cascade');
            $table->string('medicine_meal_relation')->nullable()->comment('e.g. Before meal, After meal');
            $table->text('medicine_instructions')->nullable();
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 20. PRESCRIPTION MEDICINE DOSE DURATION
        // ─────────────────────────────────────────────
        Schema::create('prescription_medicine_dose_durations', function (Blueprint $table) {
            $table->id('prescription_medicine_dose_duration_id');
            $table->foreignId('prescription_id')->constrained('prescriptions', 'prescription_id')->onDelete('cascade');
            $table->string('medicine_dose', 30)->nullable()->comment('e.g. 1+0+1+0');
            $table->foreignId('medicine_unit_id')->nullable()->constrained('medicine_units', 'unit_id')->nullOnDelete();
            $table->string('medicine_duration', 50)->nullable()->comment('e.g. 5 days');
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 21. PATIENT TREATMENT PLANS
        // ─────────────────────────────────────────────
        Schema::create('treatment_plans', function (Blueprint $table) {
            $table->id('treatment_plan_id');
            $table->foreignId('prescription_id')->constrained('prescriptions', 'prescription_id')->onDelete('cascade');
            $table->string('treatment_plan_name');
            $table->foreignId('treatment_plan_assigned_doctor_id')->constrained('doctors', 'doctors_id')->onDelete('cascade');
            $table->tinyInteger('treatment_plan_status')->default(1);
            $table->timestamps();
        });

        // ─────────────────────────────────────────────
        // 22. DOCTORS APPOINTMENTS
        // ─────────────────────────────────────────────
        Schema::create('doctors_appointments', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->foreignId('patient_id')->constrained('patients', 'patient_id')->onDelete('cascade');
            $table->foreignId('doctors_id')->constrained('doctors', 'doctors_id')->onDelete('cascade');
            $table->dateTime('appointment_date');
            $table->tinyInteger('appointment_status')->default(1)->comment('1=Pending, 2=Confirmed, 3=Cancelled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop in reverse dependency order
        Schema::dropIfExists('doctors_appointments');
        Schema::dropIfExists('treatment_plans');
        Schema::dropIfExists('prescription_medicine_dose_durations');
        Schema::dropIfExists('prescription_medicines');
        Schema::dropIfExists('prescription_advices');
        Schema::dropIfExists('prescription_investigations');
        Schema::dropIfExists('prescription_diagnoses');
        Schema::dropIfExists('prescription_examinations');
        Schema::dropIfExists('prescription_complaints');
        Schema::dropIfExists('prescription_logs');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('advices');
        Schema::dropIfExists('investigations');
        Schema::dropIfExists('diagnoses');
        Schema::dropIfExists('examinations');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('medicine_units');
        Schema::dropIfExists('medicines');
        Schema::dropIfExists('doctors_assistants');
        Schema::dropIfExists('doctors_schedules');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('patients');
    }
};