<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Subject;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('students')->paginate(10);
        return view('admin.manage-course', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:courses,name',
            'code' => 'required|string|max:50|unique:courses,code',
            'description' => 'required|string',
            'credits' => 'nullable|integer|min:0|max:20',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $course = Course::with('subjects')->where('slug', $slug)->firstOrFail();
        return view('admin.course-detail', compact('course'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }

    public function attachForm($slug)
    {
        $course = Course::where("slug", $slug)->firstOrFail();
        $subjects = Subject::all();
        return view('admin.attach-subject', compact('course', 'subjects'));
    }

    public function attach(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $course->subjects()->attach($request->subject_id);

        return redirect()->route('courses.show', $course->slug)->with('success', 'Subject attached successfully.');
    }

    public function detach($courseId, $subjectId)
    {
        $course = Course::findOrFail($courseId);

        $course->subjects()->detach($subjectId);

        return redirect()->route('courses.show', $courseId)->with('success', 'Subject detached successfully.');
    }
}
