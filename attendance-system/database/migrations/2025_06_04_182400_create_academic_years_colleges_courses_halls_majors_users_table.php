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
        Schema::create('academic_years_colleges_courses_halls_majors_users', function (Blueprint $table) {
            $table->id();
            $table->enum('type',App\Enums\CourseType::values());
            $table->foreignId('academic_year_id');
            $table->foreignId('college_id');
            $table->foreignId('course_id');
            $table->foreignId('hall_id');
            $table->foreignId('major_id');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_years_colleges_courses_halls_majors_users');
    }
};
