np<?php

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
        Schema::create('conditions', function (Blueprint $table) {
            $table->id('conditionId');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('condition_symptoms', function (Blueprint $table) {
            $table->id('conditionSymptomId');
            $table->unsignedBigInteger('conditionId');
            $table->unsignedBigInteger('symptomId');
            $table->timestamps();

            $table->foreign('conditionId')->references('conditionId')->on('conditions')->onDelete('cascade');
            $table->foreign('symptomId')->references('symptomId')->on('symptoms')->onDelete('cascade');
        });

        Schema::create('condition_herbs', function (Blueprint $table) {
            $table->id('conditionHerbId');
            $table->unsignedBigInteger('conditionId');
            $table->unsignedBigInteger('herbId');
            $table->timestamps();

            $table->foreign('conditionId')->references('conditionId')->on('conditions')->onDelete('cascade');
            $table->foreign('herbId')->references('herbId')->on('herbs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('condition_herbs');
        Schema::dropIfExists('condition_symptoms');
        Schema::dropIfExists('conditions');
    }
};
