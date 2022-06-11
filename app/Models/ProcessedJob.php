<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProcessedJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'temp_id',
        'batch_id',
        'payload',
        'status',
        'remarks',
    ];

    protected $appends = [
        'batch'
    ];

    public function getBatchAttribute()
    {
        return DB::table('job_batches')->where('id', $this->attributes['batch_id'])->first();
    }

}
