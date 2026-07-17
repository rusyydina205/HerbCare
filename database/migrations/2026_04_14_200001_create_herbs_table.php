<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('herbs', function (Blueprint $table) {
            $table->id('herbId');
            $table->string('herbName');
            $table->string('scientificName');
            $table->text('benefits');
            $table->text('preparation');
            $table->text('safety');
            $table->unsignedBigInteger('categoryId');
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('categoryId')
                  ->references('categoryId')
                  ->on('health_categories')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('herbs');
    }
};
