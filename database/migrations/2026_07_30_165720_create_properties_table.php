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
        Schema::create('properties', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->text('description');

            $table->string('property_type');
            $table->string('purpose');

            $table->decimal('price', 12, 2);
            $table->decimal('deposit', 12, 2)->nullable();

            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('balconies')->nullable();

            $table->decimal('area', 10, 2);

            $table->string('furnishing');

            $table->boolean('parking')->default(false);

            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');

            $table->string('image')->nullable();

            $table->enum('status', [
                'Available',
                'Rented'
            ])->default('Available');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};