<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('herb_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patientId');
            $table->unsignedBigInteger('herbId');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('patientId')->references('patientId')->on('patients')->onDelete('cascade');
            $table->foreign('herbId')->references('herbId')->on('herbs')->onDelete('cascade');

            $table->index(['patientId', 'herbId']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('herb_views');
    }
};
