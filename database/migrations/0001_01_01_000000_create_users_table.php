<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // No central users table needed as we use separate patients and practitioners tables.
        // Sessions and cache are handled via file driver in .env.
    }

    public function down(): void
    {
        // Nothing to drop here as we've removed the tables.
    }
};
