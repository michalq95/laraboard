<?php

namespace Database\Factories;

use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{

    protected $model = Offer::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {


        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'description' => $this->faker->realText,
            'status' => 'active',
            'bracket_low' => $this->faker->numberBetween(3000, 5000),
            'bracket_high' => $this->faker->numberBetween(5001, 10000),
            'expire_date' => Carbon::now()->addMonth(),
            'currency' => "PLN",
            'icon' => $this->faker->randomElement(["java", "js", "php", "python", "vue", ""]),
            'company_id' => $this->faker->numberBetween(1, 10),


        ];
    }
}