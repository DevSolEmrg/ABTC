<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = ['patient_history_id', 'designated_day', 'date', 'time', 'vaccine_id'];
    protected $appends = ['vaccine'];

    public function history()
    {
        return $this->belongsTo(PatientHistory::class);
    }

    public function getVaccineAttribute()
    {
        return Vaccine::whereId($this->attributes['vaccine_id'])->first();
    }

}
