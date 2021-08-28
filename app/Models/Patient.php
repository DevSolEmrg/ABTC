<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'civil_status',
        'birth_date',
        'address',
        'contact_number'
    ];

    protected $appends = ['date'];

    public function getDateAttribute()
    {
        return $this->birth_date;
    }

    public function history()
    {
        return $this->hasMany(PatientHistory::class);
    }

    public function last_history()
    {
        return $this->hasOne(PatientHistory::class)->ofMany('date_of_incident');
    }
}
