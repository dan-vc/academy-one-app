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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreign('teacher_id')
                ->constrained('teachers')
                ->nullable()
                ->nullOnDelete();
            $table->string('course_code')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->smallInteger('credits');
            $table->integer('max_capacity');
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
