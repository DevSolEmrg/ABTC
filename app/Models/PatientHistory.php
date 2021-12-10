<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'date_of_incident',
        'place_of_incident',
        'date_of_physical_exam',
        'place_of_physical_exam',
        'type_of_animal_id',
        'type_of_exposure_id',
        'site_of_infection_id',
        'is_washed',
        'route',
        'category_id',
        'outcome_id',
        'biting_animal_status_id',
        'remarks'
    ];

    // protected $appends = [
    //     'type_of_animal',
    //     'type_of_exposure',
    //     'site_of_infection',
    //     'category',
    //     'outcome',
    //     'biting_animal_status',
    // ];

    protected $casts = [
        'site_of_infection_id' => 'array',
        // 'is_washed' => 'boolean'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function treatment()
    {
        return $this->hasMany(Treatment::class);
    }

    // public function getTypeOfAnimalAttribute()
    // {
    //     return Reference::get([
    //         'id',
    //         'reference_category_id',
    //         'code',
    //         'desc'
    //     ])->only([$this->attributes['type_of_animal_id']]);
    // }

    // public function getTypeOfExposureAttribute()
    // {
    //     return Reference::get([
    //         'id',
    //         'reference_category_id',
    //         'code',
    //         'desc'
    //     ])->only([$this->attributes['type_of_exposure_id']]);
    // }

    // public function getSiteOfInfectionAttribute()
    // {
    //     return Reference::get([
    //         'id',
    //         'reference_category_id',
    //         'code',
    //         'desc'
    //     ])->only(json_decode($this->attributes['site_of_infection_id']));
    // }

    // public function getCategoryAttribute()
    // {
    //     return Reference::get([
    //         'id',
    //         'reference_category_id',
    //         'code',
    //         'desc'
    //     ])->only([$this->attributes['category_id']]);
    // }

    // public function getOutcomeAttribute()
    // {
    //     return Reference::get([
    //         'id',
    //         'reference_category_id',
    //         'code',
    //         'desc'
    //     ])->only([$this->attributes['outcome_id']]);
    // }

    // public function getBitingAnimalStatusAttribute()
    // {
    //     return Reference::get([
    //         'id',
    //         'reference_category_id',
    //         'code',
    //         'desc'
    //     ])->only([$this->attributes['biting_animal_status_id']]);
    // }

}
