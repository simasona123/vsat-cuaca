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
        Schema::create('alor_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at');
            $table->string('feedback');
        });

        Schema::create('merauke_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at');
            $table->string('feedback');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alor_feedbacks');
        Schema::dropIfExists('merauke_feedbacks');
    }
};
