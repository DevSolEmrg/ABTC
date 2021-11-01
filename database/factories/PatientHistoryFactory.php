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
            'date_of_incident' => $this->faker->dateTime(now()),
            'place_of_incident' => $this->faker->address(),
            'date_of_physical_exam' => $this->faker->dateTime(now()),
            'place_of_physical_exam' => $this->faker->address(),
            'type_of_animal' => $this->faker->randomElement(['PD', 'PC']),
            'type_of_exposure' => $this->faker->randomElement(['B', 'NB']),
            'site_of_infection' => $this->faker->randomElement(['R FOOT', 'L LEG', 'L ARM', 'L HAND', 'R LEG', 'BUTTOCKS', 'R HAND']),
            'is_washed' => true,
            'route' => 'ID',
            'category' => $this->faker->randomElement(['1', '2', '3']),
            'outcome' => $this->faker->randomElement(['C', 'INC', 'N', 'D']),
            'biting_animal_status' => $this->faker->randomElement(['ALIVE', 'DEAD', 'LOST']),
            'remarks' => $this->faker->text()
        ];
    }
}
