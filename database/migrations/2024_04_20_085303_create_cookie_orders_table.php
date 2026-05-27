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
        Schema::create('cookie_orders', function (Blueprint $table) {
            $table->id();
            $table->date('date_pick_up')->nullable();
            $table->boolean('active')->default(true);
//            $table->time('time_slot')->nullable();
            $table->string('time_slot')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone_number')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('comment')->nullable();
            $table->integer('total_price') ->nullable();
            $table->boolean('is_new') ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cookie_orders');
    }
};
