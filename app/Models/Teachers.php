<?php

namespace App\Models;

use App\Traits\GetFullName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teachers extends Model {
    use getFullName;

    protected $fillable = [
        'lastname', 'firstname', 'secondname', 'email'
    ];

    protected $dates = ['created_at, updated_at'];

    protected $appends = ['full_name'];

    /**
     * @return string|null
     */
    public function getFullNameAttribute(): ?string {
        return $this->getFullName();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function courses(): BelongsToMany {
        return $this->belongsToMany('App\Models\Courses', 'courses_teachers', 'teacher_id', 'course_id');
    }
}
