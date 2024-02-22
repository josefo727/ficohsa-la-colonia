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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 32)->index();
            $table->string('complete', 512);
            $table->string('cancel', 512);
            $table->string('currency', 16);
            $table->decimal('amount', 16, 2);
            $table->string('email', 64);
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('callback', 512);
            $table->string('vtex_status')->default('payment-pending');
            $table->string('status')->default('needs_approval');
            $table->timestamp('order_creation_at');
            $table->timestamp('resolution_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
