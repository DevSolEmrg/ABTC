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
        'birth_date',
        'address'
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
}
