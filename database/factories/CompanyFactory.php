<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{

    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'slug' => $this->faker->slug,
            'status' => 1,
            'description' => $this->faker->sentences(5, true),
            'address' => "Warszawa",
            'loc_y' => $this->faker->latitude(52.064, 52.365),
            'loc_x' => $this->faker->longitude(20.82, 21.2),

        ];
    }
}