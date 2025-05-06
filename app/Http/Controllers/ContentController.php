<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $subslug = $request->query("sub");
        $subjects = Subject::select('name', 'id', 'slug')->get();

        if ($subslug) {
            $subject = Subject::where('slug', $subslug)->first();

            if ($subject) {
                $topics = Topic::where('subject_id', $subject->id)
                    ->select(["id", "slug", "name", "description", "subject_id"])
                    ->paginate(10);
            } else {
                $topics = Topic::select(["id", "slug", "name", "description", "subject_id"])
                    ->paginate(10);
            }
        } else {
            $topics = Topic::select(["id", "slug", "name", "description", "subject_id"])
                ->paginate(10);
        }

        return view("admin.manage-content", compact("subjects", "topics"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Content $content)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content $content)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Content $content)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content)
    {
        //
    }
}
