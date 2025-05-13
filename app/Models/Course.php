<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'credits',
        'duration_weeks',
        'base_price',
        'is_active',
    ];


    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'credits' => 'integer',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_courses')->withTimestamps();
    }

    public function getActiveStudentCount()
    {
        return $this->students()
            ->where('status', 'active')
            ->count();
    }

    protected static function booted()
    {
        static::creating(function ($course) {
            $course->slug = Str::slug($course->name);
        });
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'course_subjects');
    }
}
