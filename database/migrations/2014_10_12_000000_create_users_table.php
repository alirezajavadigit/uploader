<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration // Define a new anonymous class extending the Migration class
{
    /**
     * Run the migrations.
     *
     * This method is called when the migration is executed.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) { // Create a new table 'users'
            $table->id(); // Auto-incrementing ID column
            $table->string('rememeberToken'); // String column for remember token (note: typo here, it should be 'rememberToken')
            $table->timestamps(); // Timestamps for created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method is called when the migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('users'); // Drop the 'users' table if it exists
    }
};
