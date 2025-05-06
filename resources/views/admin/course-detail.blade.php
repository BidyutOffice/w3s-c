@extends('layouts.admin')

@section('main')
    <!-- Page Title -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">{{ $course->name }} <span class="text-slate-400">({{ $course->code }})</span></h1>
            <p class="text-sm text-gray-500">Manage course details and subjects.</p>
        </div>
        <a href="{{ route('courses.subjects.attach', $course->slug) }}" class="btn btn-primary">Attach Subject</a>
    </div>

    <!-- Flash Message -->
    <x-flash-message />

    <!-- Course Details -->
    <div class="bg-slate-700 p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-semibold mb-4">Course Details</h2>
        <div class="space-y-2">
            <p>{{ $course->description ?? 'N/A' }}</p>
            <p><strong>Credits:</strong> {{ $course->credits ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Subjects Section -->
    <div class="bg-slate-700 p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Subjects</h2>

        @if ($course->subjects->count())
            <ul class="space-y-4">
                @foreach ($course->subjects as $subject)
                    <li class="flex justify-between items-center border-b pb-2">
                        <div>
                            <p class="font-semibold">{{ $subject->name }}</p>
                            <p class="text-sm text-gray-600">{{ $subject->description ?? 'No description' }}</p>
                        </div>
                        <form action="{{ route('courses.subjects.detach', [$course->id, $subject->id]) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to detach this subject?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Detach</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No subjects attached to this course yet.</p>
        @endif
    </div>
@endsection
