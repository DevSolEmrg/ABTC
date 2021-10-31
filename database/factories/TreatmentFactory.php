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
            //on database seeder
            //'patient_history_id' => PatientHistory::inRandomOrder()->first()->id,
            //'designated_day' => $this->faker->randomElement(['D0', 'D3', 'D7', 'D14', 'D28', 'ERIG']),
            'date' => $this->faker->date(),
            'time' => '12:00',
            'vaccine_id' => Vaccine::inRandomOrder()->first()->id
        ];
    }
}
