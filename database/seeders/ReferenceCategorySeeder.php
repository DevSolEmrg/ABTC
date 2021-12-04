<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferenceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $category = [
            [ 'name' => 'Type Of Animal' ],
            [ 'name' => 'Type Of Exposure' ],
            [ 'name' => 'Site Of Infection' ],
            [ 'name' => 'Category' ],
            [ 'name' => 'Outcome' ],
            [ 'name' => 'Biting Animal Status' ]
        ];

        foreach($category as $key=>$ctg) {
            $category[$key] = array_merge($ctg, array("created_at" => now(), "updated_at" => now()));
        }

        DB::table('reference_categories')->insert($category);
    }
}
