<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ManageStudentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $courseCode = $request->query('course');
        $statusFilter = $request->query('status');
        $studentsQuery = Student::with('courses');

        if ($courseCode) {
            $studentsQuery->whereHas('courses', function ($query) use ($courseCode) {
                $query->where('code', $courseCode);
            });
        }

        if ($statusFilter) {
            $studentsQuery->where('status', $statusFilter);
        }

        $students = $studentsQuery->orderBy('id', "desc")->get();
        $courses = Course::all();
        $status = ["active", "pending", "completed", "discontinued", "suspended"];

        return view('admin.students', compact('students', 'courses', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view("admin.manage-students", compact("courses"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $course = Course::findOrFail($request->course_id);

        $regId = 'IMS' . $course->code . now()->format('Ym') . str_pad(
            Student::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count() + 1,
            4,
            '0',
            STR_PAD_LEFT
        );

        $dob = Carbon::parse($request->date_of_birth)->format('Ymd');
        $password = strtolower(Str::limit($request->first_name . $request->last_name, 4, '')) . $dob;

        $student = Student::create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'phone_number'  => $request->phone_number,
            'address'       => $request->address,
            'city'          => $request->city,
            'state'         => $request->state,
            'zip_code'      => $request->zip_code,
            'gender'        => $request->gender,
            'reg_id'        => $regId,
            'password'      => Hash::make($password),
        ]);

        // Store pivot data with or without EMI
        $student->courses()->attach($course->id, [
            'sold_price'     => $request->sold_price,
            'discount'       => $request->discount ?? 0,
            'enrolment_fee'  => $request->enrolment_fee,
            'payment_mode'   => $request->payment_mode,
            'emi_months'     => $request->payment_mode === 'emi' ? $request->emi_months : null,
            'emi_amount'     => $request->payment_mode === 'emi' ? $request->emi_amount : null,
            'emi_start_date' => $request->payment_mode === 'emi' ? $request->emi_start_date : null,
        ]);

        // Update slug
        $student->update([
            'slug' => $student->id . '-' . Str::slug($student->first_name . ' ' . $student->last_name),
        ]);

        return redirect()->route('students.index')->with('success', 'Student registered successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $student = Student::with([
            'studentCourses.course',
            'studentCourses.payments'
        ])->where('slug', $slug)->firstOrFail();

        return view('admin.student_show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
