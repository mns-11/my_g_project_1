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
        Schema::table('users', function (Blueprint $table) {
             $table->foreignId('college_id')->nullable()->constrained('colleges')->cascadeOnDelete();
            $table->foreignId('major_id')->nullable()->constrained('majors')->cascadeOnDelete();
            $table->foreignId('level_id')->nullable()->constrained('levels')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('college_id');
            $table->dropForeign('major_id');
            $table->dropForeign('level_id');
            $table->drop('college_id');
            $table->drop('major_id');
            $table->drop('level_id');
        });
    }
};
