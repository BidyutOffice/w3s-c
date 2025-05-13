<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePayments extends Model
{
    protected $table = 'course_payments';

    protected $fillable = [
        'student_courses_id',
        'amount',
        'payment_date',
        'reference_no',
        'method',
        'notes',
    ];

    public function studentCourse()
    {
        return $this->belongsTo(StudentCourse::class, 'student_courses_id');
    }

    public function addedBy()
    {
        return $this->belongsTo(Student::class, 'added_by');
    }
}
