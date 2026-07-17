<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('symptoms', function (Blueprint $table) {
            $table->id('symptomId');
            $table->string('symptomName');
            $table->unsignedBigInteger('categoryId');
            $table->timestamps();

            $table->foreign('categoryId')
                  ->references('categoryId')
                  ->on('health_categories')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symptoms');
    }
};
