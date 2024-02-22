<?php

namespace Database\Factories;

use App\Models\CreditInquiryLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class CreditInquiryLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CreditInquiryLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'query_date' => $this->faker->dateTimeThisYear(),
            'ip' => $this->faker->ipv4(),
            'document' => $this->faker->numerify('##########'),
            'success' => $this->faker->boolean(),
            'response' => $this->faker->boolean() ? $this->faker->text(200) : null,
            'error' => $this->faker->boolean() ? $this->faker->text(200) : null,
        ];
    }
}
