<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name =  $this->faker->name;
        return [
            'name'           => $name,
            'email'          => $this->faker->unique()->safeEmail,
            'password'       => bcrypt('secret'), 
            'phone'          => $this->faker->phoneNumber,
            'ocupation'      => rand(1,2), 
            'name_tax'       => $name,
            'tax_id'         => 'CF', 
            'weight'         => rand(190,185),
            'height'         => rand(1.90,1.80), 
            'marital_status' => rand(1,2),
            'insurance'      => rand(1,2), 
            'birthdate'      => '1994-10-04', 
        ];
    }
}




