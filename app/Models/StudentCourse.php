<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    protected $table = 'student_courses';

    protected $fillable = [
        'student_id',
        'course_id',
        'sold_price',
        'discount',
        'enrolment_fee',
        'payment_mode',
        'emi_months',
        'emi_amount',
        'emi_start_date',
        'payment_status',
        'is_active',
        'notes',
    ];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function payments()
    {
        return $this->hasMany(CoursePayments::class, 'student_courses_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
