<?php

namespace App\Http\Controllers;

use App\Models\CoursePayments;
use App\Models\Student;
use App\Models\StudentCourse;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = CoursePayments::with([
            'studentCourse.student',
            'studentCourse.course',
        ])->latest('payment_date')->paginate();

        // dd($payments);

        return view("admin.manage-payments", compact('payments'));
    }

    public function create()
    {
        $students = Student::with('courses')->get();
        $studentsList = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
                'reg_id' => $student->reg_id,
                'courses' => $student->courses->map(function ($course) {
                    return [
                        'id' => $course->id,
                        'name' => $course->name,
                    ];
                })->toArray(),
            ];
        });

        return view("admin.make-payment", compact("studentsList"));
    }

    public function searchStudent(Request $request)
    {
        $query = Student::query();

        if ($request->filled('reg_id')) {
            $query->where('reg_id', 'like', '%' . $request->reg_id . '%');
        }

        if ($request->filled('name')) {
            $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$request->name}%"]);
        }

        $students = $query->with('courses')->limit(10)->get();

        return response()->json(['students' => $students]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'    => 'required|exists:students,id',
            'course_id'     => 'required|exists:courses,id',
            'amount'        => 'required|numeric|min:0',
            'payment_date'  => 'required|date',
            'method'        => 'required|in:cash,card,upi,netbanking,other',
            'reference_no'  => 'nullable|string|max:255',
            'notes'         => 'nullable|string',
        ]);

        // Fetch the student_courses.id
        $studentCourse = StudentCourse::where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->firstOrFail();

        CoursePayments::create([
            'student_courses_id' => $studentCourse->id,
            'amount'             => $validated['amount'],
            'payment_date'       => $validated['payment_date'],
            'method'             => $validated['method'],
            'reference_no'       => $validated['reference_no'] ?? null,
            'notes'              => $validated['notes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }
}
