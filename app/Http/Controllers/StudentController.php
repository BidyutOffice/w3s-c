<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function courseAndPayments()
    {
        return view("student.courseAndPayments");
    }

    public function downloadPaymentsPDF()
    {
        $student = Student::with([
            'studentCourses.course',
            'studentCourses.payments'
        ])->where('slug', Auth::guard('students')->user()->slug)->firstOrFail();

        $pdf = Pdf::loadView('student.pdf.payments', compact('student'))->setPaper('a4', 'portrait');
        return $pdf->download('my-courses-payments.pdf');
    }
}
