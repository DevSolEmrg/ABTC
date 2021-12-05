<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'desc'];

    public function category()
    {
        return $this->belongsTo(ReferenceCategory::class, 'reference_category_id');
    }
}
