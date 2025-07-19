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
        Schema::create('attendance_reports', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['general', 'custom']);
            $table->foreignId('college_id')->nullable()->constrained('courses')->cascadeOnDelete();
            $table->foreignId('major_id')->nullable()->constrained('majors')->cascadeOnDelete();
            $table->foreignId('level_id')->nullable()->constrained('levels')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->json('report_data');
            $table->foreignId('generated_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_reports');
    }
};
