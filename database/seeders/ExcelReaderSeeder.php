<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ExcelReaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::get() as $user) {
            \App\Models\ExcelReader::factory()->times(1)->create([
                'user_id' => $user->id
            ]);
        }
    }
}
