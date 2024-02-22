<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $order = Order::factory()->create();

        $request = [
            'status' => 'paid',
            'ref' => $this->faker->uuid,
            'description' => $this->faker->sentence,
            'transaction_id' => $this->faker->uuid,
            'payment_hash' => $this->faker->uuid,
            'uuid' => $this->faker->uuid,
            'paid_at' => $this->faker->dateTimeThisMonth,
        ];

        $jsonString = json_encode($request);

        return [
            'status' => $request['status'],
            'approved' => true,
            'authorization_id' => $request['ref'],
            'message' => $request['description'],
            'transaction_id' => $request['transaction_id'],
            'payment_hash' => $request['payment_hash'],
            'request_id' => $request['uuid'],
            'processed' => false,
            'paid_at' => $request['paid_at'],
            'request' => $jsonString,
            'order_id' => $order->id,
        ];
    }
}
