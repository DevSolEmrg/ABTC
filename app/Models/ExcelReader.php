<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcelReader extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reader_start_on_row',
        'name_box',
    ];

    protected $casts = [
        'name_box' => 'array',
    ];

    public function setNameBoxAttribute($name_box)
    {
        $this->attributes['name_box'] = strtoupper($name_box);
    }

}
