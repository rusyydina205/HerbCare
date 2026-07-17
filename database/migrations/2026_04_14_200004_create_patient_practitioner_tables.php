<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Patient profile & auth table
        Schema::create('patients', function (Blueprint $table) {
            $table->id('patientId');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password'); // Auth field
            $table->string('phone')->nullable();
            $table->string('profile_photo')->nullable(); // Profile photo field
            $table->timestamp('email_verified_at')->nullable(); // Auth field
            $table->rememberToken(); // Auth field
            $table->timestamps();
        });

        // Practitioner / Staff profile & auth table
        Schema::create('practitioners', function (Blueprint $table) {
            $table->id('practitionerId');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password'); // Auth field
            $table->string('phone')->nullable();
            $table->string('profile_photo')->nullable(); // Profile photo field
            $table->timestamp('email_verified_at')->nullable(); // Auth field
            $table->rememberToken(); // Auth field
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('practitioners');
        Schema::dropIfExists('patients');
    }
};
