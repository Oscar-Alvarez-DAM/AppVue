<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class courses extends Model
{
    protected $fillable = ['name', 'description'];

    public function students(): HasMany
    {
        return $this->hasMany(students::class, 'course_id');
    }
}
