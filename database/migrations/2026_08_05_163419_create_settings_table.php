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
        Schema::create('settings', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Website Information
            |--------------------------------------------------------------------------
            */

            $table->string('website_name');

            $table->string('logo')->nullable();

            $table->string('favicon')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Contact Information
            |--------------------------------------------------------------------------
            */

            $table->string('contact_email')->nullable();

            $table->string('contact_phone')->nullable();

            $table->text('address')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Footer
            |--------------------------------------------------------------------------
            */

            $table->string('footer_text')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Social Links
            |--------------------------------------------------------------------------
            */

            $table->string('facebook')->nullable();

            $table->string('instagram')->nullable();

            $table->string('linkedin')->nullable();

            $table->string('twitter')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};