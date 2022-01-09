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
        $g = [
            // 'patient_id' => Patient::inRandomOrder()->first()->id,
            // 'date_of_incident' => $this->faker->dateTime(now()),
            // 'place_of_incident' => $this->faker->address(),
            // 'date_of_physical_exam' => $this->faker->dateTime(now()),
            // 'place_of_physical_exam' => $this->faker->address(),
            // 'type_of_animal' => $this->faker->randomElement(['PD', 'PC']), //collect((new Constants())->type_of_animal)->pluck('id')->toArray()
            // 'type_of_exposure' => $this->faker->randomElement(['B', 'NB']),
            // 'site_of_infection' => array_rand(array_flip(['R FOOT', 'L LEG', 'L ARM', 'L HAND', 'R LEG', 'BUTTOCKS', 'R HAND']), rand(2,4)),
            // 'is_washed' => true,
            // 'route' => 'ID',
            // 'category' => $this->faker->randomElement(['1', '2', '3']),
            // 'outcome' => $this->faker->randomElement(['C', 'INC', 'N', 'D']),
            // 'biting_animal_status' => $this->faker->randomElement(['ALIVE', 'DEAD', 'LOST']),
            // 'remarks' => $this->faker->text()
            'patient_id' => Patient::inRandomOrder()->first()->id,
            'registration_number' => null,
            'registration_date' => now()->timezone('Asia/Manila'),
            'age_of_patient' => null,
            'date_of_incident' => $this->faker->dateTime(now()),
            'place_of_incident' => $this->faker->address(),
            'date_of_physical_exam' => $this->faker->dateTime(now()),
            'place_of_physical_exam' => $this->faker->address(),
            'type_of_animal_id' =>  array_rand(array_flip(collect((new \App\Constants())->type_of_animal)->pluck('id')->toArray()), 1),
            'type_of_exposure_id' => array_rand(array_flip(collect((new \App\Constants())->type_of_exposure)->pluck('id')->toArray()), 1),
            'site_of_infection_id' => array_rand(array_flip(collect((new \App\Constants())->site_of_infection)->pluck('id')->toArray()), rand(2,4)),
            'is_washed' => true,
            'rig_date_given' => null,
            'route' => 'ID',
            'category_id' => array_rand(array_flip(collect((new \App\Constants())->category)->pluck('id')->toArray()), 1),
            'outcome_id' => array_rand(array_flip(collect((new \App\Constants())->outcome)->pluck('id')->toArray()), 1),
            'biting_animal_status_id' => array_rand(array_flip(collect((new \App\Constants())->biting_animal_status)->pluck('id')->toArray()), 1),
            'doctors_order' => $this->faker->text(),
            'nurses_notes' => $this->faker->text(),
            'remarks' => $this->faker->text(),
        ];
        info("gg", $g);
        return $g;
    }
}
