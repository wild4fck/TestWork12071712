<?php

namespace App\Models;

use App\Traits\GetFullName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Students extends Model {
    use getFullName;

    protected $fillable = [
        'lastname', 'firstname', 'secondname', 'age', 'email', 'characteristic'
    ];

    protected $dates = ['created_at, updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function coursesTeachers(): BelongsToMany {
        return $this->belongsToMany('App\Models\CoursesTeachers', 'student_courses_teacher', 'student_id', 'course_teacher_id');
    }

}
