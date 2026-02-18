<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class students extends Model
{
    protected $fillable = ['name', 'email', 'course_id'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(courses::class, 'course_id');
    }
}
