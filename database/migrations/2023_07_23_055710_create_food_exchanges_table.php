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
        Schema::create('food_exchanges', function (Blueprint $table) {
            $table->id();
            $table->json('measurement_units')->nullable();
            $table->string('image')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            // $table->double('quantity')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('type', ['starch', 'fruit', 'dairy', 'vegetable', 'meat', 'fat'])->default('starch');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_exchanges');
    }
};
