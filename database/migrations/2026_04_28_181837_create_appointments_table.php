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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patientId');
            $table->unsignedBigInteger('practitionerId')->nullable();
            $table->unsignedBigInteger('message_id')->nullable();
            $table->date('preferred_date');
            $table->time('preferred_time');
            $table->text('reason');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();

            $table->foreign('patientId')->references('patientId')->on('patients')->onDelete('cascade');
            $table->foreign('practitionerId')->references('practitionerId')->on('practitioners')->onDelete('set null');
            $table->foreign('message_id')->references('messageId')->on('messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
