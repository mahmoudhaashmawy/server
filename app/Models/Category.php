<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class, 'category_id');
    }

    public function seminars()
    {
        return $this->hasMany(Seminar::class, 'category_id');
    }
}
