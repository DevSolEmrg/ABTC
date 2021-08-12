<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\PatientHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PatientHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'patient_id' => Patient::inRandomOrder()->first()->id,
            'date' => $this->faker->date(),
            'place' => $this->faker->address(),
            'type_of_animal' => $this->faker->randomElement(['PD', 'PC']),
            'type' => $this->faker->randomElement(['B', 'NB']),
            'body_parts' => $this->faker->randomElement(['R FOOT', 'L LEG', 'L ARM', 'L HAND', 'R LEG', 'BUTTOCKS', 'R HAND']),
            'outcome' => $this->faker->randomElement(['C', 'INC', 'N', 'D']),
            'biting_animal_status' => $this->faker->randomElement(['alive', 'dead', 'lost']),
            'remarks' => $this->faker->text()
        ];
    }
}
