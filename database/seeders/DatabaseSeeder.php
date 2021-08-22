<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Patient::factory(123)->create();
        \App\Models\PatientHistory::factory(1000)->create();
        \App\Models\Vaccine::factory(17)->create();

        \App\Models\User::create([
            'name' => 'John Doe Dee',
            'email' => 'johndoe@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

    }
}
