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
        Schema::create('template_webpages', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->longText('content')->nullable();
            $table->string('picture_1')->nullable();
            $table->string('picture_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_webpages');
    }
};
