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
        Schema::create('bookings', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */

            $table->foreignId('property_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('tenant_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('landlord_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Visit Details
            |--------------------------------------------------------------------------
            */

            $table->date('visit_date');

            $table->time('visit_time');

            $table->text('message')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Booking Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'Pending',
                'Approved',
                'Rejected',
                'Completed'
            ])->default('Pending');

            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};