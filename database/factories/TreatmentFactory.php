<?php

namespace Database\Factories;

use App\Models\{PatientHistory, Treatment, Vaccine};
use Illuminate\Database\Eloquent\Factories\Factory;

class TreatmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Treatment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'patient_history_id' => PatientHistory::inRandomOrder()->first()->id,
            'designated_day' => $this->faker->randomElement(['0', '3', '7', '28', 'ERIG']),
            'date' => $this->faker->date(),
            'vaccine_id' => Vaccine::inRandomOrder()->first()->id
        ];
    }
}
