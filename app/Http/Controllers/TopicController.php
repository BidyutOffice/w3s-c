<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subslug = $request->query("sub");
        $subjects = Subject::select('name', 'id', 'slug')->get();

        if ($subslug) {
            $subject = Subject::where('slug', $subslug)->first();

            if ($subject) {
                $topics = Topic::where('subject_id', $subject->id)
                    ->select(["id", "slug", "sequence", "name", "description", "subject_id"])
                    ->orderBy("sequence", "asc")
                    ->paginate(10);
            } else {
                $topics = Topic::select(["id", "slug", "sequence", "name", "description", "subject_id"])
                    ->paginate(10);
            }
        } else {
            $topics = Topic::select(["id", "slug", "sequence", "name", "description", "subject_id"])
                ->paginate(10);
        }

        return view("admin.manage-topic", compact("topics", "subjects"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::select('name', 'id')->get();
        return view("admin.add-topic", compact("subjects"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => ["required", "string", "max:255"],
            "subject_id" => ["required", "exists:subjects,id"],
            "description" => ["required", "string", "max:500"]
        ]);

        $subject = Subject::find($request->subject_id);

        if (!$subject) {
            return redirect()->back()->with("error", "Invalid subject ID.");
        }

        $baseSlug = Str::slug($subject->name . "-" . $request->name);
        $slug = $baseSlug;
        $counter = 1;

        while (Topic::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $result = Topic::create([
            "name" => $request->name,
            "slug" => $slug,
            "subject_id" => $request->subject_id,
            "description" => $request->description
        ]);

        if ($result) {
            return redirect()->back()->with("success", "Topic added successfully.");
        } else {
            return redirect()->back()->with("error", "Failed to add topic!");
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        $result = $topic->delete();
        if ($result) {
            return redirect()->back()->with("success", "deleted successfully");
        } else {
            return redirect()->back()->with("error", "Failed to add subject!");
        }
    }

    public function reorder(Request $request)
    {
        $orderedIds = $request->orderedIds;

        foreach ($orderedIds as $index => $id) {
            Topic::where('id', $id)->update(['sequence' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
