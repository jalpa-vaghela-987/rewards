<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company,
            'description' => $this->faker->unique()->catchPhrase,
            'logo_path' => 'https://cdn4.iconfinder.com/data/icons/logos-and-brands/512/258_Pied_Piper_logo-512.png',
            'background_path'  => 'https://brobible.com/wp-content/uploads/2018/03/silicon-valley-opening-credits-sequence.jpg',
            'in_trial_mode' => 0,
        ];
    }
}
