<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Use the built-in Authenticatable trait
use Illuminate\Notifications\Notifiable;
use App\Models\Course;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];
    protected $table = 'students';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'date_of_birth',
        'phone_number',
        'address',
        'city',
        'state',
        'zip_code',
        'gender',
        'reg_id',
        'status',
        'slug',
        'password'
    ];
    protected $hidden = ['password'];

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_courses')
            ->withTimestamps()
            ->withPivot([
                'sold_price',
                'discount',
                'enrolment_fee',
                'payment_mode',
                'emi_months',
                'emi_amount',
                'emi_start_date',
                'notes',
            ]);
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }
}
