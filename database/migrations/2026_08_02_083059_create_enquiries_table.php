<?php

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
        Schema::create('enquiries', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */

            // Property receiving the enquiry
            $table->foreignId('property_id')
                ->constrained()
                ->cascadeOnDelete();

            // User who sends the enquiry (Tenant)
            $table->foreignId('sender_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Property owner receiving the enquiry (Landlord)
            $table->foreignId('receiver_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Enquiry Details
            |--------------------------------------------------------------------------
            */

            $table->text('message');

            $table->enum('status', [
                'Pending',
                'Replied',
                'Closed'
            ])->default('Pending');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};