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
        Schema::table('messages', function (Blueprint $table) {
            $table->text('reply')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->boolean('is_read')->default(false);
            $table->dropColumn('status');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->enum('status', ['pending', 'replied', 'resolved'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['reply', 'replied_at', 'is_read']);
            $table->dropColumn('status');
        });
        
        Schema::table('messages', function (Blueprint $table) {
            $table->enum('status', ['pending', 'completed'])->default('pending');
        });
    }
};
