<?php
namespace App;

class Constants {

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

    public function enumValues()
    {
        return [
            'type_of_animal' => $this->type_of_animal,
            'type_of_exposure' => $this->type_of_exposure,
            'site_of_infection' => $this->site_of_infection,
            'category' => $this->category,
            'outcome' => $this->outcome,
            'bitting_animal_status' => $this->bitting_animal_status,
            'is_washed' => $this->is_washed
        ];
    }

}