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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // Core
            $table->string('code')->unique(); // MHS_xxx
            $table->string('school_year')->default('2026-2027');
            $table->string('status')->default('draft'); // draft, submitted, approved
            $table->timestamp('submitted_at')->nullable();

            // JSON blocks
            $table->json('addresses')->nullable();
            $table->json('siblings')->nullable();
            $table->json('abilities')->nullable();
            $table->json('health_info')->nullable();
            $table->json('family_info')->nullable();
            $table->json('registration')->nullable();
            $table->json('commitment')->nullable();

            $table->timestamps();
        });
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->foreignId('application_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('full_name');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('date_of_birth')->nullable();

            $table->string('ethnicity')->nullable();
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();

            $table->string('personal_id')->nullable();

            $table->string('place_of_birth')->nullable();
            $table->string('birth_certificate_place')->nullable();
            $table->string('hometown')->nullable();

            $table->string('phone')->nullable();

            $table->timestamps();
        });

        Schema::create('guardians', function (Blueprint $table) {
            $table->id();

            $table->foreignId('application_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('type', ['father', 'mother', 'guardian']);

            $table->string('full_name')->nullable();
            $table->integer('birth_year')->nullable();

            $table->string('job')->nullable();
            $table->string('position')->nullable();

            $table->string('phone')->nullable();
            $table->string('personal_id')->nullable();

            $table->timestamps();

            $table->index(['application_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
        Schema::dropIfExists('students');
        Schema::dropIfExists('guardians');
    }
};
