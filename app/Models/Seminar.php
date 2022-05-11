<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    protected $casts = [
        'included' => 'object',
        'excluded' => 'object',
        'seminar_plan' => 'object',
        'images' => 'object'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'plan_id')->where('type', 'seminar');
    }
}
