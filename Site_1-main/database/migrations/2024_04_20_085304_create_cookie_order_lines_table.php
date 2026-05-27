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
        Schema::create('cookie_order_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cookie_order_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('cookie_id')->constrained()->onDelete('restrict')->onUpdate('restrict');
            $table->integer('number_of_packs')->nullable();
            $table->integer(('price'))->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cookie_order_lines');
    }
};
