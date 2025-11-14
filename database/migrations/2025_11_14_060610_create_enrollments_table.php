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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreign('student_id')
                ->constrained('students')
                ->restrictOnDelete();
            $table->foreign('course_id')
                ->constrained('courses')
                ->restrictOnDelete();
            $table->string('period');
            $table->date('enrollment_date')->default(now());
            $table->enum('status', ['enrolled', 'retired', 'approved', 'failed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
