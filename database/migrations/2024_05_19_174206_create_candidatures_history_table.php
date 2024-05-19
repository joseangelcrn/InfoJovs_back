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
        Schema::create('candidatures_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidature_id');
            $table->unsignedBigInteger('recruiter_id');
            $table->unsignedBigInteger('origin_status_id');
            $table->unsignedBigInteger('destiny_status_id');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures_history');
    }
};
