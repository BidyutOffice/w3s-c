<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePayments extends Model
{
    protected $table = "course_payments";

    public function studentCourse()
    {
        return $this->belongsTo(StudentCourse::class);
    }
}
