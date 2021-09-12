<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = ['patient_history_id', 'date', 'vaccine_id'];

    public function history()
    {
        return $this->belongsTo(PatientHistory::class);
    }

}
