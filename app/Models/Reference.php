<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $fillable = ['reference_category_id', 'code', 'desc'];

    //protected $appends = ['reference_category'];

    public function category()
    {
        return $this->belongsTo(ReferenceCategory::class, 'reference_category_id');
    }

    // public function getReferenceCategoryAttribute()
    // {
    //     return ReferenceCategory::get(['id', 'name'])->only([$this->attributes['reference_category_id']]);
    // }
}
