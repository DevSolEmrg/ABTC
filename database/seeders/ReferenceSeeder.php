<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferenceSeeder extends Seeder
{

    public $type_of_animal  = [
        [
            'code' => 'PD',
            'desc' => 'Pet Dog'
        ],
        [
            'code' => 'PC',
            'desc' => 'Pet Cat'
        ]
    ];

    public $type_of_exposure = [
        [
            'code' => 'B',
            'desc' => 'Bite'
        ],
        [
            'code' => 'NB',
            'desc' => 'Non-Bite'
        ]
    ];

    public $site_of_infection = [
        [
            'code' => 'R FOOT',
            'desc' => 'Right Foot'
        ],
        [
            'code' => 'L LEG',
            'desc' => 'Left Leg'
        ],
        [
            'code' => 'L ARM',
            'desc' => 'Left Arm'
        ],
        [
            'code' => 'L HAND',
            'desc' => 'Left Hand'
        ],
        [
            'code' => 'R LEG',
            'desc' => 'Right Leg'
        ],
        [
            'code' => 'BUTTOCKS',
            'desc' => 'Buttocks'
        ],
        [
            'code' => 'R HAND',
            'desc' => 'Right Hand'
        ]
    ];

    public $category = [
        [
            'code' => '1',
            'desc' => '1'
        ],
        [
            'code' => '2',
            'desc' => '2'
        ],
        [
            'code' => '3',
            'desc' => '3'
        ]
    ];

    public $outcome = [
        [
            'code' => 'C',
            'desc' => 'C'
        ],
        [
            'code' => 'INC',
            'desc' => 'INC'
        ],
        [
            'code' => 'N',
            'desc' => 'N'
        ],
        [
            'code' => 'D',
            'desc' => 'D'
        ]
    ];

    public $bitting_animal_status = [
        [
            'code' => 'ALIVE',
            'desc' => 'Alive'
        ],
        [
            'code' => 'DEAD',
            'desc' => 'Dead'
        ],
        [
            'code' => 'LOST',
            'desc' => 'Lost'
        ]
    ];

    public $is_washed = [
        [
            'code' => '1',
            'desc' => 'YES'
        ],
        [
            'code' => '0',
            'desc' => 'NO'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type_of_animal = $this->type_of_animal;
        $type_of_exposure = $this->type_of_exposure;
        $category = $this->category;
        $outcome = $this->outcome;
        $biting_animal_status = $this->biting_animal_status;
        $site_of_infection = $this->site_of_infection;
        $is_washed = $this->is_washed;

        foreach(
            [
                'type_of_animal',
                'type_of_exposure',
                'category',
                'outcome',
                'biting_animal_status',
                'site_of_infection',
                'is_washed'
            ] as $variable_name
        ) {
            foreach(${$variable_name} as $key=>$value) {
                ${$variable_name}[$key] = array_merge($value, array(
                    'reference_category_id' => $this->getCategoryId(ucwords(str_replace('_',' ', $variable_name))),
                    "desc" => array_key_exists("desc", $value) ? $value['desc'] : $value['code'],
                    "created_at" => now(),
                    "updated_at" => now()
                ));
            }
            DB::table('references')->insert(${$variable_name});
        }

    }

    private function getCategoryId($category_name)
    {
        return \App\Models\ReferenceCategory::where('name', $category_name)->first()->id ?? null;
    }
}
