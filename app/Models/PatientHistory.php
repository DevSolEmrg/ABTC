<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'registration_number',
        'registration_date',
        'age_of_patient',
        'date_of_incident',
        'place_of_incident',
        'date_of_physical_exam',
        'place_of_physical_exam',
        'type_of_animal_id',
        'type_of_exposure_id',
        'site_of_infection_id',
        'is_washed',
        'rig_date_given',
        'route',
        'category_id',
        'outcome_id',
        'biting_animal_status_id',
        'doctors_order',
        'nurses_notes',
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

    public function setDateOfIncidentAttribute($date)
    {
        $this->attributes['date_of_incident'] =  Carbon::parse($date)->timezone('Asia/Manila')->format('Y-m-d H:i:s');
    }

    public function setDateOfPhysicalExamAttribute($date)
    {
        $this->attributes['date_of_physical_exam'] =  Carbon::parse($date)->timezone('Asia/Manila')->format('Y-m-d H:i:s');
    }

    public function setRegistrationDateAttribute($date)
    {
        $this->attributes['registration_date'] =  !!$date ? Carbon::parse($date)->timezone('Asia/Manila')->format('Y-m-d H:i:s') : null;
    }

    public function setRigDateGivenAttribute($date)
    {
        $this->attributes['rig_date_given'] =  !!$date ? Carbon::parse($date)->timezone('Asia/Manila')->format('Y-m-d H:i:s') : null;
    }

    // public function setRegistrationNumberAttribute($value)
    // {
    //     $this->attributes['registration_number'] =  !!$value ? $value : null;
    // }

    // public function setAgeOfPatientAttribute($value)
    // {
    //     $this->attributes['age_of_patient'] =  !!$value ? $value : null;
    // }

    // public function setDoctorsOrderAttribute($value)
    // {
    //     $this->attributes['doctors_order'] =  !!$value ? $value : null;
    // }

    // public function setNursesNotesAttribute($value)
    // {
    //     $this->attributes['nurses_notes'] =  !!$value ? $value : null;
    // }

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
