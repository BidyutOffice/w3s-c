@extends('layouts.admin')

@section('main')
    <h1>Attach Subject to {{ $course->name }}</h1>

    <form action="{{ route('courses.subjects.attach.store', $course->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="subject_id">Select Subject</label>
            <select name="subject_id" id="subject_id" class="form-control bg-slate-700">
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Attach</button>
    </form>
@endsection
