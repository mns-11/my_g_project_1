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
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type',App\Enums\CourseType::values());
            $table->foreignId('level_id')->constrained('levels')->cascadeOnDelete();
            $table->foreignId('major_id')->constrained('majors')->cascadeOnDelete();
            $table->foreignId('college_id')->nullable()->constrained('colleges')->cascadeOnDelete();
            $table->boolean('is_blocked')->default(false);
            $table->mediumInteger('hours');
            $table->enum('term', App\Enums\AcademicTerm::values());
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
