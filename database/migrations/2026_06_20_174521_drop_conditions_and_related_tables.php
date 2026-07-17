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
        Schema::dropIfExists('condition_herbs');
        Schema::dropIfExists('condition_symptoms');
        Schema::dropIfExists('conditions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed for drop
    }
};
