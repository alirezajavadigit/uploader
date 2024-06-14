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
        Schema::create('links', function (Blueprint $table) { // Create a new table 'links'
            $table->id(); // Auto-incrementing ID column
            $table->foreignId("user_id")->constrained("users")->cascadeOnDelete(); // Foreign key to users table, cascading on delete
            $table->string("telegram_url"); // String column for telegram URL
            $table->string("private_url"); // String column for private URL
            $table->string("file_name"); // String column for file name
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
        Schema::dropIfExists('links'); // Drop the 'links' table if it exists
    }
};
