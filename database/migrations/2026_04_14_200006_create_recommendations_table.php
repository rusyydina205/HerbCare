<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id('recommendationId');
            $table->string('herbName');
            $table->unsignedBigInteger('patientId');   // FK → patients.patientId
            $table->unsignedBigInteger('symptomId');   // FK → symptoms.symptomId
            $table->unsignedBigInteger('categoryId');  // FK → health_categories.categoryId
            $table->unsignedBigInteger('herbsId');     // FK → herbs.herbId
            $table->timestamps();

            $table->foreign('patientId')
                  ->references('patientId')
                  ->on('patients')
                  ->onDelete('cascade');

            $table->foreign('symptomId')
                  ->references('symptomId')
                  ->on('symptoms')
                  ->onDelete('cascade');

            $table->foreign('categoryId')
                  ->references('categoryId')
                  ->on('health_categories')
                  ->onDelete('cascade');

            $table->foreign('herbsId')
                  ->references('herbId')
                  ->on('herbs')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
