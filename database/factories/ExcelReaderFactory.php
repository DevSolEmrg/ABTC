<?php

namespace Database\Factories;

use App\Models\ExcelReader;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExcelReaderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExcelReader::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //'user_id'
            'reader_start_on_row' => 9,
            'name_box' => ['B', 'C', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'AC', 'AI']
        ];

        // number: dataCol[2],
        // date: this.falsableDate(dataCol[4]),
        // name: dataCol[5],
        // address: dataCol[6],
        // age: dataCol[7],
        // gender: dataCol[8],
        // date_of_inci: this.falsableDate(dataCol[9]),
        // place_of_inci: dataCol[10],
        // type_of_animal: dataCol[11],
        // type_of_exposure: dataCol[12],
        // site_of_infection: dataCol[13],
        // category: dataCol[14],
        // is_washing: dataCol[15],
        // rig_date: this.falsableDate(dataCol[16]),
        // route: dataCol[17],
        // d_one: this.falsableDate(dataCol[18]),
        // d_tree: this.falsableDate(dataCol[19]),
        // d_seven: this.falsableDate(dataCol[20]),
        // d_fourteen: this.falsableDate(dataCol[21]),
        // d_twenty_eight: this.falsableDate(dataCol[22]),
        // brand_name: dataCol[23],
        // outcome: dataCol[24],
        // animal_status: dataCol[29],
        // remarks: dataCol[35],


    }
}
