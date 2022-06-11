<?php
namespace App;

class Constants {

    // public $type_of_animal  = [
    //     [
    //         'code' => 'PD',
    //         'desc' => 'Pet Dog'
    //     ],
    //     [
    //         'code' => 'PC',
    //         'desc' => 'Pet Cat'
    //     ]
    // ];

    // public $type_of_exposure = [
    //     [
    //         'code' => 'B',
    //         'desc' => 'Bite'
    //     ],
    //     [
    //         'code' => 'NB',
    //         'desc' => 'Non-Bite'
    //     ]
    // ];

    // public $site_of_infection = [
    //     [
    //         'code' => 'R FOOT',
    //         'desc' => 'Right Foot'
    //     ],
    //     [
    //         'code' => 'L LEG',
    //         'desc' => 'Left Leg'
    //     ],
    //     [
    //         'code' => 'L ARM',
    //         'desc' => 'Left Arm'
    //     ],
    //     [
    //         'code' => 'L HAND',
    //         'desc' => 'Left Hand'
    //     ],
    //     [
    //         'code' => 'R LEG',
    //         'desc' => 'Right Leg'
    //     ],
    //     [
    //         'code' => 'BUTTOCKS',
    //         'desc' => 'Buttocks'
    //     ],
    //     [
    //         'code' => 'R HAND',
    //         'desc' => 'Right Hand'
    //     ]
    // ];

    // public $category = [
    //     [
    //         'code' => '1',
    //         'desc' => '1'
    //     ],
    //     [
    //         'code' => '2',
    //         'desc' => '2'
    //     ],
    //     [
    //         'code' => '3',
    //         'desc' => '3'
    //     ]
    // ];

    // public $outcome = [
    //     [
    //         'code' => 'C',
    //         'desc' => 'C'
    //     ],
    //     [
    //         'code' => 'INC',
    //         'desc' => 'INC'
    //     ],
    //     [
    //         'code' => 'N',
    //         'desc' => 'N'
    //     ],
    //     [
    //         'code' => 'D',
    //         'desc' => 'D'
    //     ]
    // ];

    // public $bitting_animal_status = [
    //     [
    //         'code' => 'ALIVE',
    //         'desc' => 'Alive'
    //     ],
    //     [
    //         'code' => 'DEAD',
    //         'desc' => 'Dead'
    //     ],
    //     [
    //         'code' => 'LOST',
    //         'desc' => 'Lost'
    //     ]
    // ];

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

    public $type_of_animal;
    public $type_of_exposure;
    public $site_of_infection;
    public $category;
    public $outcome;
    public $biting_animal_status;
    // public $is_washed;
    public $route;

    public function __construct()
    {
        $this->type_of_animal = \App\Models\Reference::with(['category'])->whereHas('category', function($q){ $q->whereName('Type Of Animal'); })->get()->toArray();
        $this->type_of_exposure = \App\Models\Reference::with(['category'])->whereHas('category', function($q){ $q->whereName('Type Of Exposure'); })->get()->toArray();
        $this->site_of_infection = \App\Models\Reference::with(['category'])->whereHas('category', function($q){ $q->whereName('Site Of Infection'); })->get()->toArray();
        $this->category = \App\Models\Reference::with(['category'])->whereHas('category', function($q){ $q->whereName('Category'); })->get()->toArray();
        $this->outcome = \App\Models\Reference::with(['category'])->whereHas('category', function($q){ $q->whereName('Outcome'); })->get()->toArray();
        $this->biting_animal_status = \App\Models\Reference::with(['category'])->whereHas('category', function($q){ $q->whereName('Biting Animal Status'); })->get()->toArray();
        // $this->is_washed = \App\Models\Reference::with(['category'])->whereHas('category', function($q){ $q->whereName('Is Washed'); })->get()->toArray();
        $this->route = \App\Models\Reference::with(['category'])->whereHas('category', function($q){ $q->whereName('Route'); })->get()->toArray();
    }

    public function enumValues()
    {
        return [
            'type_of_animal' => $this->type_of_animal,
            'type_of_exposure' => $this->type_of_exposure,
            'site_of_infection' => $this->site_of_infection,
            'category' => $this->category,
            'outcome' => $this->outcome,
            'biting_animal_status' => $this->biting_animal_status,
            'route' => $this->route,
            'is_washed' => $this->is_washed
        ];
    }

}