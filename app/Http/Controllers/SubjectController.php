<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::select("id", "slug", "name", "description")->paginate(10);
        return view("admin.manage-subject", compact("subjects"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => ["required", "string"],
            "description" => ["required", "string"]
        ]);

        $result = Subject::create([
            "name" => $request->name,
            "description" => $request->description,
            "slug" => Str::slug($request->name)
        ]);

        if ($result) {
            return redirect()->back()->with("success", "subject added");
        } else {
            return redirect()->back()->with("error", "Failed to add subject!");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        dd($subject);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $result = $subject->delete();

        if ($result) {
            return redirect()->back()->with("success", "deleted successfully");
        } else {
            return redirect()->back()->with("error", "Failed to add subject!");
        }
    }
}
