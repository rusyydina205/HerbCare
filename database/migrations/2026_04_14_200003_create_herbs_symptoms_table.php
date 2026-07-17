<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('herbs_symptoms', function (Blueprint $table) {
            $table->id('herbSymptomId');
            $table->unsignedBigInteger('herbId');
            $table->unsignedBigInteger('symptomId');
            $table->unsignedBigInteger('categoryId');
            $table->timestamps();

            $table->foreign('herbId')
                  ->references('herbId')
                  ->on('herbs')
                  ->onDelete('cascade');

            $table->foreign('symptomId')
                  ->references('symptomId')
                  ->on('symptoms')
                  ->onDelete('cascade');

            $table->foreign('categoryId')
                  ->references('categoryId')
                  ->on('health_categories')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('herbs_symptoms');
    }
};
