<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoices>
 */
class InvoicesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => $this->faker->randomNumber(),
            'invoice_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'rate_vat' => $this->faker->randomFloat(2, 0, 100),
            'value_vat' => $this->faker->randomFloat(2, 0, 100),
            'total' => $this->faker->randomFloat(2, 0, 100),
            'status' => $this->faker->randomElement([0,1,2]),
            'not' => $this->faker->text,
            'product_id' => function (){
                return Product::factory()->create()->id;
            },
            'section_id' => function () {
                return Section::factory()->create()->id;
            },

            'user_id'=>1,
            ];

    }
}
