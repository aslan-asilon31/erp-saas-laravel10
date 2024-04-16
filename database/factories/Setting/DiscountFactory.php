<?php

namespace Database\Factories\Setting;

use App\Enums\DiscountComputation;
use App\Enums\DiscountScope;
use App\Enums\DiscountType;
use App\Models\Setting\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Discount>
 */
class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Discount::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+1 year');
        $endDate = $this->faker->dateTimeBetween($startDate, strtotime('+1 year'));

        return [
            'description' => $this->faker->sentence,
            'rate' => $this->faker->biasedNumberBetween(300, 5000) * 100, // 3% - 50%
            'computation' => $this->faker->randomElement(DiscountComputation::class),
            'scope' => $this->faker->randomElement(DiscountScope::class),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'enabled' => true,
        ];
    }

    public function salesDiscount(): self
    {
        return $this->state([
            'name' => 'Summer Sale',
            'rate' => $this->faker->biasedNumberBetween(300, 1200) * 100, // 3% - 12%
            'type' => DiscountType::Sales,
        ]);
    }

    public function purchaseDiscount(): self
    {
        return $this->state([
            'name' => 'Bulk Purchase',
            'rate' => $this->faker->biasedNumberBetween(300, 1200) * 100, // 3% - 12%
            'type' => DiscountType::Purchase,
        ]);
    }
}
