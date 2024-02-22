<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Josefo727\GeneralSettings\Models\GeneralSetting;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $og = $this->faker->regexify('[1-9][0-9]{12}');
        $orderId = $og . '-01';
        $storeDomain = config('vtex.store_domain');

        return [
            'order_id' => $orderId,
            'complete' => $storeDomain . "/checkout/orderPlaced?og={$og}&action=complete",
            'cancel' => $storeDomain . "/checkout/orderPlaced?og={$og}&action=cancel",
            'currency' => $this->faker->currencyCode(),
            'amount' => $this->faker->randomFloat(2, 0, 1000),
            'email' => $this->faker->email(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'callback' => GeneralSetting::getValue('VTEX_MASTER_DOMAIN') . "/api/transaction-result/{$orderId}",
            'vtex_status' => 'payment-pending',
            'status' => 'needs_approval',
            'order_creation_at' => $this->faker->dateTime(),
        ];
    }
}
