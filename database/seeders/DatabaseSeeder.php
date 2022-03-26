<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ReferenceCategorySeeder::class,
            ReferenceSeeder::class
        ]);

        \App\Models\User::factory(8)->create();
        \App\Models\Patient::factory(53)->create();
        \App\Models\PatientHistory::factory(200)->create();
        \App\Models\Vaccine::factory(17)->create();
        \App\Models\Personnel::factory(20)->create();

        DB::table('patient_histories')->orderBy('created_at')->chunk(70, function($histories)
        {
            foreach ($histories as $history)
            {
                foreach (['D0', 'D3', 'D7', 'D14', 'D28', 'ERIG'] as $value) {
                    \App\Models\Treatment::factory()->create([
                        'patient_history_id' => $history->id,
                        'designated_day' => $value
                    ]);
                }
            }
        });

        // foreach(\App\Models\PatientHistory::get() as $history) {
        //     foreach (['D0', 'D3', 'D7', 'D14', 'D28', 'ERIG'] as $value) {
        //         \App\Models\Treatment::factory()->create([
        //             'patient_history_id' => $history->id,
        //             'designated_day' => $value
        //         ]);
        //     }
        // }

        $default_user = \App\Models\User::create([
            'name' => 'John Doe Dee',
            'email' => 'johndoe@gmail.com',
            'email_verified_at' => now(),
            'password' => 'password',//'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $default_user2 = \App\Models\User::create([
            'name' => 'Alex Tier',
            'email' => 'alex@gmail.com',
            'email_verified_at' => now(),
            'password' => 'password',//'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $roles = [
            'super-admin',
            'physician',
            'nurse'
        ];

        $permissions = [
            //patient
            'create-patient-record',
            'read-patient-record',
            'update-patient-record',
            'delete-patient-record',
            'manage-patient-record',
            'import-patient-record',
            'print-patient-record',
            'generate-patient-report',
            //personnel
            'create-personnel',
            'read-personnel-info',
            'update-personnel-info',
            'delete-personnel',
            'manage-personnel-info',
            //vaccine
            'create-vaccine',
            'read-vaccine-info',
            'update-vaccine-info',
            'delete-vaccine-info',
            'manage-vaccine-info',
            //user management
            'create-user-account',
            'read-user-account-info',
            'update-user-account',
            'delete-user-account',
            'manage-user-account',
            //role & permission
            'create-role',
            'read-role-info',
            'update-role-info',
            'delete-role',
            'manage-role',
            //app instance
            'create-app_instance',
            'read-app_instance',
            'update-app_instance',
            'delete-app_instance',
            'manage-app_instance',
            //reports
            'generate-report',
        ];

        foreach($permissions as $permit) {
            Permission::create(['name' => $permit]);
        }

        foreach($roles as $role_key=>$role) {
            $role = Role::create(['name' => $role, 'description' => $this->random_words(rand(3,7), rand(3,10))]);

            if ($role_key == 0) {
                foreach($permissions as $key=>$value) {
                    $pi = $key + 1;
                    $permission = Permission::find($pi);

                    $role->givePermissionTo($permission->name);
                    $permission->assignRole($role->name);
                }
            } else {
                foreach($permissions as $key=>$value) {
                    $pi = $key + 1;
                    if ($pi < 7) {
                        $permission = Permission::find($pi);

                        $role->givePermissionTo($permission->name);
                        $permission->assignRole($role->name);
                    }
                }
            }
        }
        $default_user->assignRole('super-admin');
        $default_user2->assignRole('physician');

    }

    private function random_words($words = 1, $length = 6)
    {
        $string = '';
        for ($o=1; $o <= $words; $o++)
        {
            $vowels = array("a","e","i","o","u");
            $consonants = array(
                'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm',
                'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'
            );

            $word = '';
            for ($i = 1; $i <= $length; $i++)
            {
                $word .= $consonants[rand(0,19)];
                $word .= $vowels[rand(0,4)];
            }
            $string .= mb_substr($word, 0, $length);
            $string .= " ";
        }
        return mb_substr($string, 0, -1);
    }

}
