<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Vaccine;

class VaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vaccine::factory()->times(10)->create();
    }
}
