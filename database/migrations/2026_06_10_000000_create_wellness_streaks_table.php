<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wellness_streaks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patientId');
            $table->date('date');
            $table->timestamp('checked_at')->nullable();
            $table->timestamps();

            $table->unique(['patientId', 'date']);
            $table->foreign('patientId')->references('patientId')->on('patients')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wellness_streaks');
    }
};
