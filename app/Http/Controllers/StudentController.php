<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class StudentController extends Controller
{
    protected $student;

    public function __construct()
    {
        $this->student = Student::with([
            'studentCourses.course',
            'studentCourses.payments'
        ])->where('slug', Auth::guard('students')->user()->slug)->firstOrFail();

        View::share('student', $this->student);
    }

    public function dashboard()
    {
        return view("student.dashboard");
    }

    public function profile()
    {
        return view("student.profile");
    }
}
