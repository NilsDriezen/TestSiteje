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
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('instruction')->nullable();
            $table->integer('preparation_time')->nullable();
            $table->integer('serving')->nullable();
            $table->string('recipe_tag')->nullable();
            $table->text('comment')->nullable();
            $table->integer('calorie')->nullable();
            $table->boolean('active');
            $table->foreignId('course_id')->constrained()->onDelete('restrict')->onUpdate('restrict');
            $table->string('path')->nullable();
            $table->integer('cooking_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dishes');
    }
};
