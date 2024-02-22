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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('status', 16);
            $table->boolean('approved');
            $table->string('authorization_id', 64);
            $table->string('message', 256);
            $table->string('transaction_id', 64);
            $table->string('payment_hash');
            $table->string('request_id');
            $table->boolean('processed')->default(false);
            $table->timestamp('paid_at');
            $table->json('request', 4096)->nullable();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
