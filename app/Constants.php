<?php
namespace App;

class Constants {

    public $type_of_animal  = [
        [
            'code' => 'PD',
            'desc' => 'PD'
        ],
        [
            'code' => 'PC',
            'desc' => 'PC'
        ]
    ];

    public $type_of_exposure = [
        [
            'code' => 'B',
            'desc' => 'B'
        ],
        [
            'code' => 'NB',
            'desc' => 'NB'
        ]
    ];

    public $site_of_infection = [
        'R FOOT',
        'L LEG',
        'L ARM',
        'L HAND',
        'R LEG',
        'BUTTOCKS',
        'R HAND'
    ];

    public $category = [
        '1',
        '2',
        '3'
    ];

    public $outcome = [
        'C',
        'INC',
        'N',
        'D'
    ];

    public $bitting_animal_status = [
        'ALIVE',
        'DEAD',
        'LOST'
    ];

    public function enumValues()
    {
        return [
            'type_of_animal' => $this->type_of_animal,
            'type_of_exposure' => $this->type_of_exposure,
            'site_of_infection' => $this->site_of_infection,
            'category' => $this->category,
            'outcome' => $this->outcome,
            'bitting_animal_status' => $this->bitting_animal_status
        ];
    }

}