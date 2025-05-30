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
        'reg_id',
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
        'status',
        'role',
        'slug',
        'is_active',
        'last_login_at',
        'password'
    ];

    protected static function booted()
    {
        // static::creating(function ($student) {
        //     if (empty($student->password)) {
        //         $student->password = bcrypt("default1234");
        //     }
        // });
    }

    protected $hidden = ['password'];

    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }

    public function getPaymentSummary()
    {
        $pivot = $this->courses->first()?->pivot;
        $studentCourse = $this->studentCourses->first();

        // Check if studentCourse exists before trying to access payments
        $payments = $studentCourse ? $studentCourse->payments : collect();

        $paidAmount = ($pivot->enrolment_fee ?? 0) + $payments->sum('amount');
        $due = $pivot ? $pivot->sold_price - $paidAmount : 0;

        return [
            'pivot' => $pivot,
            'studentCourse' => $studentCourse,
            'payments' => $payments,
            'paidAmount' => $paidAmount,
            'due' => $due,
        ];
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
