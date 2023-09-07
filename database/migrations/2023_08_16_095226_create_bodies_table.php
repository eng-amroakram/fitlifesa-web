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
        Schema::create('bodies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();

            $table->enum('goal', ['maintain', 'gain', 'lose'])->nullable();
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->nullable();
            $table->enum('activity', ['off', 'low', 'medium', 'high'])->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->integer('age')->nullable();
            $table->float('kg_per_week')->nullable();

            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->float('BMI')->nullable();
            $table->enum('BMI_status', ['underweight', 'normal', 'overweight', 'obese'])->nullable();
            $table->float('IBM')->nullable();

            // Calories
            $table->float('calories')->nullable();
            $table->float('min_calories')->nullable();
            $table->float('max_calories')->nullable();

            // Macronutrients
            $table->float('protein_gram')->nullable();
            $table->float('protein_calories')->nullable();
            $table->float('protein_percent')->nullable();

            $table->float('carbs_gram')->nullable();
            $table->float('carbs_calories')->nullable();
            $table->float('carbs_percent')->nullable();

            $table->float('fats_gram')->nullable();
            $table->float('fats_calories')->nullable();
            $table->float('fats_percent')->nullable();

            $table->float('body_fats_percentage')->nullable();
            $table->float('body_fat_percentage_details')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bodies');
    }
};
