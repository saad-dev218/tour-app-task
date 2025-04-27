<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'created_by'
    ];

    public function images()
    {
        return $this->hasMany(TourImage::class);
    }

    public function planner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
